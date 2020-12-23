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

class TramiteController extends Controller
{

    protected $tramiteRepository;
    protected $tramiteService;

    public function __construct(
        TramiteRepository $tramiteRepository, 
        TramiteService $tramiteService)
    {
        $this->tramiteRepository = $tramiteRepository;
        $this->tramiteService = $tramiteService;
        $this->middleware('auth');
    }

    /**
     * Vista que permite roles de user y admin
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request, TramiteTipo $tramiteTipo, Tramite $tramite)
    {
        // TODO: Factory Pattern: Validar tramites_tipos, pasos y que rol puede acceder
        $request->user()->authorizeRoles(['user', 'admin']);
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
        if(!empty($tramite_id) && !empty($tramiteTipoId))
        {
            // Primero nos aseguramos de que el tramite exista en bd relacional
            $tramite = Tramite::where([
                'tramite_tipo_id'  => $tramiteTipoId,
                'id' => $tramite_id,
            ])->first() ?? abort(404);
            $tramite_id = $tramite->id; // Sobreescribimos el id del tramite para usarlo en mongodb
        }
        else
        {
            // o lo creamos
            $tramite = new Tramite;
            $tramite->tramite_tipo_id = $tramiteTipoId;
            $tramite->user_id = $request->user()->id;
            $tramite->save();

            $tramite_id = $tramite->id;
        }
        $tramiteTipo = TramiteTipo::where(['id'=>$tramiteTipoId])->first() ?? abort(404);

        $mongoTramite = $this->tramiteService->saveDataMongoTramite($tramite_id, $tramiteTipoId, $paso_data, $paso_num);
        
        $nextPaso = $this->tramiteService->getNextPaso($tramite, $mongoTramite, $tramiteTipo);
        $lastPasoCompleted = $mongoTramite->getLastPasoCompleted();

        if($this->tramiteService->isLastPaso($nextPaso, $lastPasoCompleted))
        {
            return redirect()->route('home');
        }

        // TODO: Mostrar los datos actuales que guardó (paso actual)
        // TODO: Pasar al siguiente paso
        return redirect()->route('tramite', ['tramiteTipo'=> $tramiteTipo, 'tramite'=>$tramite]);
        
    }

    
    
}