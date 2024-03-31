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
        Schema::create('rol_personal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('departamentoId');
            $table->unsignedBigInteger('servicioId');
            $table->unsignedBigInteger('estadoId');
            $table->integer('anio');
            $table->integer('mes');
            $table->text('observacion')->nullable()->default(null);
            $table->text('validacion')->nullable()->default(null);
            $table->unsignedBigInteger('registraId');
            $table->unsignedBigInteger('revisaId')->nullable()->default(null);
            $table->dateTime('fechaHoraRevisa')->nullable()->default(null);
            $table->string('filePath')->nullable()->default(null);
            $table->string('fileName')->nullable()->default(null);
            
            $table->timestamps();

            $table->foreign('departamentoId')->references('id')->on('departamento_hospital');
            $table->foreign('servicioId')->references('id')->on('servicio');
            $table->foreign('estadoId')->references('id')->on('estado_rol');
            $table->foreign('registraId')->references('id')->on('empleado');
            $table->foreign('revisaId')->references('id')->on('empleado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rol_personal');
    }
};
