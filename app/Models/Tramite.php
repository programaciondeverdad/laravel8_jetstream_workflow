<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tramite extends Model
{
    use HasFactory;

    public function user()
    {
        return $this
            ->belongsTo('App\Models\User');
    }

    public function tramiteTipo()
    {
        return $this
            ->belongsTo('App\Models\TramiteTipo');
    }

/*    public function toArray(){
        return [
            'id' => $this->id
        ];
    }*/
}
