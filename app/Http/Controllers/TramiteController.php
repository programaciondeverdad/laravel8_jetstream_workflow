<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use App\Models\TramiteTipo;
use App\Models\Tramite;

class TramiteController extends Controller
{

    public function __construct()
    {
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
        $request->user()->authorizeRoles(['user', 'admin']);
        // dd($tramite->id);
        if(!empty($tramite->id))
        {
            $tramite = Tramite::where([
                'tramite_tipo_id'  => $tramiteTipo->id,
                'id' => $tramite->id,
            ])->first() ?? abort(404);
        }
        // TODOs
        // TODO: Conocer el paso en que está el tramite si se busca por ID

        // TODO: Agregar validación de rol y usuario creador del tramite?

        return Inertia::render("Tramites/{$tramiteTipo->slug}/paso1", [
            'tramite' => $tramite,
        ]);
    }
    
}