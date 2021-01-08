<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\Tramite;
use App\Models\TramiteTipo;
use App\Models\TramiteTiposRolePasos;
use App\Models\MongoTramite;

class TramiteTiposRolePasosRepository
{

    /*
    Buscamos todos los pasos disponibles para este tramite_tipo y role
    */
    public function findPasos(TramiteTipo $tramiteTipo, Role $role)
    {
        $entity = TramiteTiposRolePasos::where([
                'tramite_tipos_id' => $tramiteTipo->id,
                'role_id'  => $role->id
            ])->all() ?? null;
        // dd($tramite_id, $tramiteTipo);
        return $entity;
    }

    /*
    Tomamos el paso máximo de pasos que puede avanzar este tramite_tipo para este role actual.
    */
    public function findMaxPasoByTramiteTipoAndRole(TramiteTipo $tramiteTipo, Role $role)
    {
        $entity = TramiteTiposRolePasos::where([
                'tramite_tipos_id' => $tramiteTipo->id,
                'role_id'  => $role->id,
                'estado' => 'A'
            ])->max('paso') ?? null;
        return $entity;
    }



    public function getRolesByPaso(TramiteTipo $tramiteTipo, int $paso_actual)
    {
        $tramiteTiposRolePasos = TramiteTiposRolePasos::where([
                'tramite_tipos_id' => $tramiteTipo->id,
                'paso'  => $paso_actual,
                'estado' => 'A'
            ])->get() ?? [];
        return $tramiteTiposRolePasos;
    }
    
}