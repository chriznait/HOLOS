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
            $table->string('turno', 10);
            $table->tinyInteger('dia');
            $table->timestamps();

            $table->foreign('rolEmpleadoId')->references('id')->on('rol_personal_empleado')->onDelete('cascade');
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
