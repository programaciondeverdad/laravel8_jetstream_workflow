<?php

/**
 * TramiteService
 */

namespace App\Services;

use App\Repositories\TramiteTiposRolePasosRepository;
use App\Models\TramiteTipo;
use App\Models\Role;

class TramiteTiposRolePasosService
{
    protected $TramiteTiposRolePasosRepository;
    
    public function __construct(TramiteTiposRolePasosRepository $TramiteTiposRolePasosRepository)
    {
        $this->TramiteTiposRolePasosRepository = $TramiteTiposRolePasosRepository;
    }

    /* 
    Buscamos si el paso actual es el número máximo de pasos que tiene este role actual 
    y lo comparamos con el paso actual del tramite
    Si son iguales, significa que el tramite para este role ya terminó.
    */
    public function isLastPasoFor(TramiteTipo $tramiteTipo, Role $role, int $paso_actual)
    {
        $paso_maximo = $this->TramiteTiposRolePasosRepository->findMaxPasoByTramiteTipoAndRole($tramiteTipo, $role);
        // dd($paso_maximo, $paso_actual);
        return intval($paso_maximo) < $paso_actual;
    }
}