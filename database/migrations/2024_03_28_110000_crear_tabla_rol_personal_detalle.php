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
        Schema::create('rol_personal_detalle', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rolEmpleadoId');
            $table->unsignedBigInteger('turnoId');
            $table->timestamps();

            $table->foreign('rolEmpleadoId')->references('id')->on('rol_personal_empleado');
            $table->foreign('turnoId')->references('id')->on('turno');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rol_personal_detalle');
    }
};
