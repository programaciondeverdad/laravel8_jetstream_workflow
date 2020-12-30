<?php

namespace App\Form;

use App\Models\MongoTramite;

abstract class Paso
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($mongo_tramite, array $input)
    {
        $this->validateInputs($input); // Valida todos los inputs del paso

        $this->validateFileInputs($input); // Valida todos los inputs file del paso

// dd("asdadasdsad");
        $this->saveFiles($mongo_tramite, $input); // Guarda los archivos
    }


    // Valida los inputs (datos del formulario)
    abstract protected function validateInputs(array $input);/*
    // Ejemplo de implementación
    {
        // validamos todos los campos del paso 1
        Validator::make($input['datos'], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'fecha_nacimiento' => ['required', 'date', 'before:' . date('Y-m-d') . ''],
            'domicilio_pais' => ['required', 'string', 'max:255'],
        ])->validateWithBag('updateTramiteInformation');
    }*/

    // Valida los files recibidos del formulario
    abstract protected function validateFileInputs(array $input);

    // Guarda los files en carpeta y en MongoTramite
    abstract protected function saveFiles(MongoTramite $mongo_tramite, array $input);

    public function getAutorizeRoles()
    {
        return ['user', 'admin'];
    }
   
    
}