<?php

namespace App\Repositories;

use App\Models\TramiteTipo;
use App\Models\Tramite;
use App\Models\MongoTramite;

class TramiteRepository
{
    
    public function findTramite(int $tramite_id, TramiteTipo $tramiteTipo)
    {
        if(!empty($tramite_id))
        {
            $tramite = Tramite::where([
                'tramite_tipo_id'  => $tramiteTipo->id,
                'id' => $tramite->id,
            ])->first() ?? null;

        }

        return $tramite;
    }

    public function findMongoTramite(int $tramite_id, TramiteTipo $tramiteTipo)
    {
        $tramiteM = MongoTramite::where([
                'tramite_id' => $tramite_id, // de la relacional
                'tramite_tipo_id'  => $tramiteTipo->id
            ])->first() ?? null;
        // dd($tramite_id, $tramiteTipo);
        return $tramiteM;

    }


    
    
}