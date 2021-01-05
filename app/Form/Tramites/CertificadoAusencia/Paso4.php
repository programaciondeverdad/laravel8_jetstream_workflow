<?php

namespace App\Form\Tramites\CertificadoAusencia;

use App\Form\Paso;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\MongoTramite;

class Paso4 extends Paso
{
    protected $paso_numero = 4;
    protected $tramite_tipo_id = 1;

    protected function validateInputs(array $input)
    {
        // validamos todos los campos del paso 1
        Validator::make($input['datos'], [
            'firma' => ['required', 'string', 'max:255'],
            'apruebo_ausencia' => ['required', 'boolean'],
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

    public function getAuthorizeRoles()
    {
        return ['user', 'admin'];
    }
}
