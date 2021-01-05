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
}