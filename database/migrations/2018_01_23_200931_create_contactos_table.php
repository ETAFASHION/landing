<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contactos', function (Blueprint $collection) {
            $collection->integer('id');
            $collection->string('nombres');
            $collection->string('apellidos');
            $collection->string('email')->unique();
            $collection->string('movil');
            $collection->date('fecha_nacimiento');
            $collection->string('ciudad');
            $collection->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contactos');
    }
}
