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
        Schema::create('rol_personal_empleado', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rolId');
            $table->unsignedBigInteger('empleadoId');
            $table->unsignedBigInteger('tipoContratoId');
            $table->unsignedBigInteger('cargoId')->nullable();
            $table->unsignedBigInteger('profesionId')->nullable();
            $table->timestamps();

            $table->foreign('rolId')->references('id')->on('rol_personal')->onDelete('cascade');
            $table->foreign('empleadoId')->references('id')->on('empleado');
            $table->foreign('tipoContratoId')->references('id')->on('tipo_contrato');
            $table->foreign('cargoId')->references('id')->on('cargo');
            $table->foreign('profesionId')->references('id')->on('profesion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rol_personal_empleado');
    }
};
