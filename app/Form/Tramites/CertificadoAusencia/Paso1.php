<?php

namespace App\Form\Tramites\CertificadoAusencia;

use App\Form\Paso;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\MongoTramite;

class Paso1 extends Paso
{
    protected function validateInputs(array $input)
    {
        // validamos todos los campos del paso 1
        Validator::make($input['datos'], [
            'name' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'fecha_nacimiento' => ['required', 'date', 'before:' . date('Y-m-d') . ''],
            'tipo_documento' => ['required', 'string', 'max:255'],
            'documento_identidad' => ['required', 'numeric', 'max:300000'],
            'domicilio_calle' => ['required', 'string', 'max:255'],
            'domicilio_numero' => ['required', 'numeric', 'max:999999'],
            'domicilio_codigo_postal' => ['required', 'string', 'max:255'],
            'domicilio_departamento_piso' => ['nullable', 'string', 'max:255'],
            'domicilio_localidad' => ['required', 'string', 'max:255'],
            'domicilio_partido' => ['required', 'string', 'max:255'],
            'domicilio_provincia' => ['required', 'string', 'max:255'],
            'domicilio_pais' => ['required', 'string', 'max:255'],
        ])->validateWithBag('updateTramiteInformation');

    }

    protected function validateFileInputs(array $input)
    {
        Validator::make($input, [
            'file_documento_identidad' => ['required', 'image', 'max:1024'],
        ])->validateWithBag('updateTramiteInformation');

    }

    protected function saveFiles(MongoTramite $mongo_tramite, array $input)
    {
        if (isset($input['file_documento_identidad'])) {
            $mongo_tramite->updateFile($input['file_documento_identidad'], 'file_documento_identidad');
        }
    }

    public function getAutorizeRoles()
    {
        return ['user'];
    }
}
