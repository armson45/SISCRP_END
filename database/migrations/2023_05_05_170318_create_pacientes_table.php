<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->char('codigo',10);
            $table->string('nombreCom',45);
            $table->string('numTel',12);
            $table->date('fechaNacimiento');
            $table->date('fechaRegistro');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on ('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
   
};
