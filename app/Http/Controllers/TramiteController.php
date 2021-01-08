<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use App\Models\TramiteTipo;
use App\Models\Tramite;
use App\Models\MongoTramite;
use App\Repositories\TramiteRepository;
use App\Services\TramiteService;
use App\Factories\PasoFactoryProducer;
use App\Services\TramiteTipoService;

class TramiteController extends Controller
{

    protected $tramiteRepository;
    protected $tramiteService;

    public function __construct(
        TramiteRepository $tramiteRepository, 
        TramiteService $tramiteService,
        TramiteTipoService $tramiteTipoService)
    {
        $this->tramiteRepository = $tramiteRepository;
        $this->tramiteService = $tramiteService;
        $this->tramiteTipoService = $tramiteTipoService;
        $this->middleware('auth');
    }

    /**
     * Vista que renderiza la pantalla del tramite actual
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request, TramiteTipo $tramiteTipo, Tramite $tramite)
    {
        $nextPaso = 1; // Iniciamos siempre con el paso1
        $lastPasoCompleted = 1;
        $actualPaso = 1;

        // Validar que el tramite existe
        if(!empty($tramite->id))
        {
            $mongoTramite = $this->tramiteRepository->findMongoTramite($tramite->id, $tramiteTipo) ?? abort(404);

            // Si ya está guardado en Mongo, entonces seguro hay otro paso para mostrar
            // Conocer el paso siguiente a mostrar en que está el tramite si se busca por ID
            $nextPaso = $this->tramiteService->getNextPaso($tramite, $mongoTramite, $tramiteTipo);
            $lastPasoCompleted = $mongoTramite->getLastPasoCompleted();
            $actualPaso = $lastPasoCompleted + 1;
        }

        /*Factory Pattern para la creación de Pasos para validar y otras cosas...*/
        $pasoFactory = PasoFactoryProducer::getFactory($tramiteTipo->id);
        // Obtiene un objeto Paso y llama al método getAuthorizeRoles
        
        $paso = $pasoFactory->getPaso($nextPaso);
        /**
         * Si está en el ultimo paso permitido para este usuario, redireccionamos a home
         * Si tiene permiso para ver lo dejamos continuar
         * Si no tiene permiso para ver, abortamos con error de permiso
        */
        // dd($request->user()->roles());
        // dd($request->user()->isAuthorizePaso($paso));
        // Si es su ultimo paso, redirigimos a la página de finalización
        if($paso->isLastPasoFor($request->user()->roles()))
        {
        // dd("llegas");
            // Redireccionamos a terminaste de cargar todo!
            return redirect()->route('home');
        }

        // Si no tiene permiso para ver el próximo paso, redirigimos a la pagina principal
        if(!$request->user()->isAuthorizePaso($paso))
        {
            // Redireccionamos a home
            return redirect()->route('home');
        }
        
        // TODO: Agregar validación usuario creador del tramite?
        return Inertia::render("Tramites/{$tramiteTipo->slug}/paso{$nextPaso}", [
            'tramite' => $tramite,
            'tramiteTipo' => $tramiteTipo->id,
            'datos' => $mongoTramite->pasos["paso$actualPaso"] ?? [],
            'isLast' => $this->tramiteService->isLastPaso($nextPaso, $lastPasoCompleted)
        ]);
    }

    /**
     * Crear o actualizar un tramite
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function createOrUpdate(Request $request)
    {
        // TODO: Rollback si tramiteM no se creo
        $tramite_id = $request->input('tramite');
        $tramiteTipoId = $request->input('tramiteTipo');

        $paso_num = $request->input('paso')?? 1;
        
        $paso_data = $request->input('datos')?? abort(404); // Si no paso la data tiramos error

        // TODO: Factory Pattern: Validar tramites_tipos, pasos y que rol puede acceder
        $request->user()->authorizeRoles(['user', 'admin']);

        // Si viene con tramite, entonces hay que actualizarlo en mongoBD
        $tramite_id = $this->getTramiteCreateOrUpdate($tramite_id, $tramiteTipoId);


        $tramiteTipo = $this->tramiteTipoService->find($tramiteTipoId) ?? abort(404);

        $mongoTramite = $this->tramiteService->saveDataMongoTramite($tramite_id, $tramiteTipoId, $paso_data, $paso_num);
        



        /*Factory Pattern para la creación de Pasos para validar y otras cosas...*/
        $pasoFactory = PasoFactoryProducer::getFactory($tramiteTipoId);
        // Obtiene un objeto Paso y llama al método update
        $paso = $pasoFactory->getPaso($paso_num);

        $paso->update($mongoTramite, $request->all()); // Valida y actualiza datos del paso (files, etc)

        $mongoTramite->save(); // Ahora sí guardamos!




        $nextPaso = $this->tramiteService->getNextPaso($tramite, $mongoTramite, $tramiteTipo);
        $lastPasoCompleted = $mongoTramite->getLastPasoCompleted();

        if($this->tramiteService->isLastPaso($nextPaso, $lastPasoCompleted))
        {
            return redirect()->route('home');
        }

        // TODO: Mostrar los datos actuales que guardó (paso actual)
        // TODO: Pasar al siguiente paso
        // dd(route('tramite', ['tramiteTipo'=> $tramiteTipo, 'tramite'=>$tramite]));
        return redirect()->route('tramite', ['tramiteTipo'=> $tramiteTipo, 'tramite'=>$tramite]);

        
    }

    

    
    
}