<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TramiteTipo;

class TramiteTipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tramiteTipo = new TramiteTipo();
        $tramiteTipo->nombre = 'Certificado de Ausencia';
        $tramiteTipo->slug = 'certificado-ausencia';
        $tramiteTipo->precio = 500.0;
        $tramiteTipo->save();
        
        $tramiteTipo = new TramiteTipo();
        $tramiteTipo->nombre = 'Certificado de Viaje';
        $tramiteTipo->slug = 'certificado-viaje';
        $tramiteTipo->precio = 890.10;
        $tramiteTipo->save();
    }
}
