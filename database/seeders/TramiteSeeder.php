<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tramite;
use App\Models\User;
use App\Models\TramiteTipo;

class tramiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_example = User::where('name', 'User')->first();
        $user_admin = User::where('name', 'Admin')->first();

        $certificado_ausencia = TramiteTipo::where('slug', 'certificado-ausencia')->first();
        $certificado_viaje = TramiteTipo::where('slug', 'certificado-viaje')->first();

        $tramite = new Tramite();
        $tramite->tramiteTipo()->associate($certificado_ausencia);
        $tramite->user()->associate($user_example);
        $tramite->save();

        $tramite = new Tramite();
        $tramite->tramiteTipo()->associate($certificado_viaje);
        $tramite->user()->associate($user_example);
        $tramite->save();

        $tramite = new Tramite();
        $tramite->tramiteTipo()->associate($certificado_ausencia);
        $tramite->user()->associate($user_admin);
        $tramite->save();

        $tramite = new Tramite();
        $tramite->tramiteTipo()->associate($certificado_viaje);
        $tramite->user()->associate($user_admin);
        $tramite->save();


        


    }
}
