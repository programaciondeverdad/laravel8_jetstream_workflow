<?php

namespace App\Form\Tramites\CertificadoAusencia;

use App\Form\Paso;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\MongoTramite;

class Paso2 extends Paso
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
        Validator::make($input, [
            'file_certificado_ausencia' => ['required', 'image', 'max:1024'],
        ])->validateWithBag('updateTramiteInformation');

    }

    protected function saveFiles(MongoTramite $mongo_tramite, array $input)
    {
        if (isset($input['file_certificado_ausencia'])) {
            $mongo_tramite->updateFile($input['file_certificado_ausencia'], 'file_certificado_ausencia');
        }
    }

    public function getAuthorizeRoles()
    {
        return ['user'];
    }

}
