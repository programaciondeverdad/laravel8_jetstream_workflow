<?php

/**
 * TramiteService
 */

namespace App\Services;

use App\Repositories\TramiteRepository;
use App\Models\TramiteTipo;
use App\Models\Tramite;
use App\Models\MongoTramite;

class TramiteService
{
    protected $tramiteRepository;
    
    public function __construct(TramiteRepository $tramiteRepository)
    {
        $this->tramiteRepository = $tramiteRepository;
    }

    public function getLastPasoCompleted(Tramite $tramite, MongoTramite $mongoTramite, TramiteTipo $tramiteTipo = null)
    {
        if(empty($tramiteTipo))
        {
            $tramiteTipo = $tramite->tramiteTipo()->get();
        }

        return $mongoTramite->getLastPasoCompleted();

    }

    public function getNextPaso(Tramite $tramite, MongoTramite $mongoTramite, TramiteTipo $tramiteTipo = null)
    {
        $pasoCompletado = $this->getLastPasoCompleted($tramite, $mongoTramite, $tramiteTipo);
        return $tramiteTipo->cant_pasos > $pasoCompletado ? $pasoCompletado + 1 : $tramiteTipo->cant_pasos;
    }


    public function saveDataMongoTramite(int $tramite_id, int $tramite_tipo_id, array $paso_data=[], int $paso_num = 1)
    {
        /*
        Buscarlo o crearlo en mongodb
        Explicación:
            - firstOrNew no persiste en la base de datos, hay que hacer save
            - firstOrCreate si persiste en la base de datos
        */
        $mongoTramite = MongoTramite::firstOrNew(
        [
            'tramite_id' => $tramite_id, // de la relacional
            'tramite_tipo_id'  => $tramite_tipo_id
        ]);

        // Una vez encontrado o creado, agregamos los datos nuevos
        $newPaso = [
            "paso{$paso_num}" => $paso_data
        ];

        // dd($newPaso);
        $mongoTramite->pasos =  array_merge($mongoTramite->pasos?? [], $newPaso);


        return $mongoTramite;
    }


    public function isLastPaso($nextPaso, $lastPasoCompleted)
    {
        return $nextPaso == $lastPasoCompleted;
    }

    public function getTramiteCreateOrUpdate($tramite_id, $tramiteTipoId)
    {
         // Si viene con tramite, entonces hay que actualizarlo en mongoBD
        if(!empty($tramite_id) && is_numeric($tramite_id) && !empty($tramiteTipoId))
        {
            // Primero nos aseguramos de que el tramite exista en bd relacional
            $tramite = Tramite::where([
                'tramite_tipo_id'  => $tramiteTipoId,
                'id' => $tramite_id,
            ])->first() ?? abort(404);
        }
        else
        {
            // o lo creamos
            $tramite = new Tramite;
            $tramite->tramite_tipo_id = $tramiteTipoId;
            $tramite->user_id = $request->user()->id;
            $tramite->save();
        }

        return $tramite->id;
    }
}