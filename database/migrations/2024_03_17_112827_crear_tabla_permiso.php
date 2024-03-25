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
        Schema::create('permiso', function (Blueprint $table) {
            $table->id();
            $table->string('fundamento');
            $table->string('destino');
            $table->unsignedBigInteger('tipoId');
            $table->unsignedBigInteger('departamentoId');
            $table->unsignedBigInteger('servicioId');
            $table->unsignedBigInteger('empleadoId');
            $table->unsignedBigInteger('estadoId')->default(1);
            $table->unsignedBigInteger('autorizaId')->nullable()->default(null);
            $table->datetime('fechaHoraAutoriza')->nullable()->default(null);
            $table->unsignedBigInteger('responsableSalidaId')->nullable()->default(null);
            $table->datetime('fechaHoraSalida')->nullable()->default(null);
            $table->unsignedBigInteger('responsableRetornoId')->nullable()->default(null);
            $table->datetime('fechaHoraRetorno')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('tipoId')->references('id')->on('tipo_permiso');
            $table->foreign('empleadoId')->references('id')->on('empleado');
            $table->foreign('departamentoId')->references('id')->on('departamento_hospital');
            $table->foreign('servicioId')->references('id')->on('servicio');
            $table->foreign('estadoId')->references('id')->on('estado_permiso');
            $table->foreign('autorizaId')->references('id')->on('empleado');
            $table->foreign('responsableSalidaId')->references('id')->on('empleado');
            $table->foreign('responsableRetornoId')->references('id')->on('empleado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permiso');
    }
};
