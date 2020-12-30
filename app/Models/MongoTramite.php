<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as MongoModel;
use App\Traits\HasFiles;


class MongoTramite extends MongoModel
{
    use HasFiles;

    protected $collection = 'tramites';
    protected $connection = 'mongodb';

    protected $fillable = ['tramite_id', 'tramite_tipo_id', 'pasos'];

    // Si está ordenado como paso1., paso2, paso3
    // ¿Qué pasaría si alguien desordena el workflow? Habria que controlarlo y hacerlo dinámico
    public function _getLastPasoCompleted(){
        return array_key_last($this->pasos);
    }

    public function getLastPasoCompleted(){
        $last = 0; // Defino a $last como el mayor igual a cero, para que comience la logica
        foreach ($this->pasos as $key => $value) {
            $numero = str_replace('paso', '', $key); // Saco la palabra paso
            $numero = intval($numero);
            if($numero > $last)  // Comparo si es mayor a $last
            {
                $last = $numero; // Si es mayor a last, lo guardo!
            }
        }
        return $last;
    }
}
