<?php

/**
 * TramiteService
 */

namespace App\Services;

use App\Repositories\TramiteTiposRolePasoRepository;
use App\Models\TramiteTipo;
use App\Models\Role;

class TramiteTiposRolePasoService
{
    protected $tramiteTiposRolePasoRepository;
    
    public function __construct(TramiteTiposRolePasoRepository $tramiteTiposRolePasoRepository)
    {
        $this->tramiteTiposRolePasoRepository = $tramiteTiposRolePasoRepository;
    }

    /* 
    Buscamos si el paso actual es el número máximo de pasos que tiene este role actual 
    y lo comparamos con el paso actual del tramite
    Si son iguales, significa que el tramite para este role ya terminó.
    */
    public function isLastPasoFor(TramiteTipo $tramiteTipo, Role $role, int $paso_actual)
    {
        $paso_maximo = $this->tramiteTiposRolePasoRepository->findMaxPasoByTramiteTipoAndRole($tramiteTipo, $role);
        // dd($paso_maximo, $paso_actual);
        return intval($paso_maximo) < $paso_actual;
    }
}