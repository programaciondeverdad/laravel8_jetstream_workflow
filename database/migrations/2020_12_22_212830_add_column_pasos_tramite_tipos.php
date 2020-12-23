<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPasosTramiteTipos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tramite_tipos', function (Blueprint $table) {
            $table->integer('cant_pasos')
                    ->after('slug')
                    ->default(1)
                    ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tramite_tipos', function (Blueprint $table) {
            $table->dropColumn('cant_pasos');
        });
    }
}
