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
        Schema::create('empleado', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->string('apellidoPaterno', 20);
            $table->string('apellidoMaterno', 20);
            $table->string('nombres', 20);
            $table->unsignedBigInteger('tipoDocumentoId')->nullable();
            $table->string('nroDocumento', 20);
            $table->date('fechaNacimiento');
            $table->unsignedBigInteger('tipoSexoId');
            $table->unsignedBigInteger('tipoContratoId')->nullable();
            $table->unsignedBigInteger('areaId')->nullable();
            $table->unsignedBigInteger('profesionId')->nullable();
            $table->unsignedBigInteger('cargoId')->nullable();
            $table->unsignedBigInteger('departamentoId')->nullable();
            $table->unsignedBigInteger('servicioId')->nullable();
            $table->timestamps();

            $table->foreign('userId')->references('id')->on('users');
            $table->foreign('profesionId')->references('id')->on('profesion');
            $table->foreign('cargoId')->references('id')->on('cargo');
            $table->foreign('tipoDocumentoId')->references('id')->on('tipo_documento');
            $table->foreign('tipoSexoId')->references('id')->on('tipo_sexo');
            $table->foreign('tipoContratoId')->references('id')->on('tipo_contrato');
            $table->foreign('areaId')->references('id')->on('area');
            $table->foreign('departamentoId')->references('id')->on('departamento_hospital');
            $table->foreign('servicioId')->references('id')->on('servicio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleado');
    }
};
