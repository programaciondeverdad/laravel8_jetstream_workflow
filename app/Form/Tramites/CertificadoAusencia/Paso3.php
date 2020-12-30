<?php

namespace App\Form\Tramites\CertificadoAusencia;

use App\Form\Paso;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\MongoTramite;

class Paso3 extends Paso
{
    protected function validateInputs(array $input)
    {
        // validamos todos los campos del paso 1
        Validator::make($input['datos'], [
            'motivo_ausencia' => ['required', 'string', 'max:255'],
            'fecha_inicio_ausencia' => ['required', 'date', 'before:' . date('Y-m-d') . ''],
            'fecha_fin_ausencia' => ['required', 'date'],
            'fecha_fin_ausencia_no_se' => ['nullable', 'boolean'],
        ])->validateWithBag('updateTramiteInformation');

    }

    protected function validateFileInputs(array $input)
    {
        return true;
    }

    protected function saveFiles(MongoTramite $mongo_tramite, array $input)
    {
        return true;
    }

    public function getAutorizeRoles()
    {
        return ['admin'];
    }
}
