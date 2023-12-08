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
        Schema::create('antecedentes_medicos', function (Blueprint $table) {
            $table->id();
            $table->string('hipertencionArterial',2);
            $table->string('cardiopatia',2);
            $table->string('diabetesMellitu',2);
            $table->string('problemaRenal',2);
            $table->string('problemaRespiratorio',2);
            $table->string('problemaHepatico',2);
            $table->string('problemaEndocronico',2);
            $table->string('problemaHemorragico',2);
            $table->string('alergiaMedicamentos',45);
            $table->string('embarazo',2);
            $table->string('otrosMedicamentosQueToma',100);
            $table->text('otrosDatos',200);
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
        Schema::dropIfExists('antecedentes_medicos');
    }
};
