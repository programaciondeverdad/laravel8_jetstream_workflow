<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TramiteTiposRolePasos extends Model
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
}
