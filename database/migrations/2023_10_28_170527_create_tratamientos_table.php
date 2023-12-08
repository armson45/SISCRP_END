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
        Schema::create('tratamientos', function (Blueprint $table) {
            $table->id();
            $table->string('nombreTrabajo',20);
            $table->text('descripcion',200);
            $table->string('imagen',100);
            $table->decimal('precio',8,2);
            $table->date('fechaInicio')->nullable();
            $table->date('fechaFinal')->nullable();
            $table->unsignedBigInteger('especialidad_id')->nullable();
            $table->foreign('especialidad_id')->references('id')->on ('especialidades');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tratamientos');
    }
};
