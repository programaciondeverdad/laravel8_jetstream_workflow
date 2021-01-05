<?php

namespace App\Form;

use App\Models\MongoTramite;

abstract class Paso
{
    /**
     * @var TramiteTiposRolePasoService
     */
    protected $tramiteTiposRolePasoService;

    protected $paso_numero;
    protected $tramite_tipo_id;

    public function __construct(TramiteTiposRolePasoService $tramiteTiposRolePasoService)
    {
        $this->tramiteTiposRolePasoService = $tramiteTiposRolePasoService;
    }

    /**
     * Validate and update
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($mongo_tramite, array $input)
    {
        $this->validateInputs($input); // Valida todos los inputs del paso

        $this->validateFileInputs($input); // Valida todos los inputs file del paso

        $this->saveFiles($mongo_tramite, $input); // Guarda los archivos
    }


    /**
     * Valida los inputs (datos del formulario)
     * Ejemplo de implementación
     * 
     *   {
     *       // validamos todos los campos del paso 1
     *       Validator::make($input['datos'], [
     *           'name' => ['required', 'string', 'max:255'],
     *           'email' => ['required', 'email', 'max:255'],
     *          'fecha_nacimiento' => ['required', 'date', 'before:' . date('Y-m-d') . ''],
     *          'domicilio_pais' => ['nullable', 'string', 'max:255'],
     *      ])->validateWithBag('updateTramiteInformation');
     *  }
     * @param array $input 
     * @return type
     */
    abstract protected function validateInputs(array $input);
    

    /**
     * Valida los files recibidos del formulario
     * @param array $input 
     * @return type
     */
    abstract protected function validateFileInputs(array $input);

    /**
     * Guarda los files en carpeta y en MongoTramite
     * @param MongoTramite $mongo_tramite 
     * @param array $input 
     * @return type
     */
    abstract protected function saveFiles(MongoTramite $mongo_tramite, array $input);

    /**
     * Get Authorize Roles
     * @return type
     */
    public function getAuthorizeRoles()
    {
        return ['user', 'admin'];
    }

    /**
     * isLastPasoFor a User
     * @return type
     */
    public function isLastPasoFor($roles)
    {
        $anyIsLastPaso = false;
        if (is_array($roles)) {
            foreach ($roles as $role) {
                $isLastPaso = $this->tramiteTiposRolePasoService->isLastPasoFor($this->tramite_tipo, $role, $this->paso_numero);
                if ($isLastPaso === true) {
                    $anyIsLastPaso = true;
                }
            }
            return $anyIsLastPaso;
        } else {
            $isLastPaso = $this->tramiteTiposRolePasoService->isLastPasoFor($this->tramite_tipo, $roles, $this->paso_numero);
            if ($isLastPaso) {
                return true;
            }
        }
        return false;
    }
   
    
}