<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as MongoModel;

class MongoTramite extends MongoModel
{
    protected $collection = 'tramites';
    protected $connection = 'mongodb';
}
