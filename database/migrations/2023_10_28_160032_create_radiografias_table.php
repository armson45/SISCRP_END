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
        Schema::create('radiografias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',100);
            $table->date('fecha');
            $table->unsignedBigInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on ('pacientes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('radiografias');
    }
};
