<?php

/**
 * TramiteTipoService
 */

namespace App\Services;

use App\Repositories\TramiteTipoRepository;
use App\Models\TramiteTipo;
use App\Models\Tramite;
use App\Models\MongoTramite;

class TramiteTipoService
{
    protected $tramiteTipoRepository;
    
    public function __construct(TramiteTipoRepository $tramiteTipoRepository)
    {
        $this->tramiteTipoRepository = $tramiteTipoRepository;
    }

    public function find($id){
        return TramiteTipo::where(['id'=>$id])->first();
    }


}