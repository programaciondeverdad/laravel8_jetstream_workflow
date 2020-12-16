<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TramiteTiposRolePaso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tramite_tipos_role_paso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->nullable()->index(); // role
            $table->foreignId('tramite_tipos_id')->nullable()->index(); // tramite_tipo
            $table->integer('paso');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tramite_tipos_role_paso');
        //
    }
}
