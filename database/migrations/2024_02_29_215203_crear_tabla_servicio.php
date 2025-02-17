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
        Schema::create('servicio', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 100);
            $table->unsignedBigInteger('departamentoId');
            $table->unsignedBigInteger('areaId')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('departamentoId')->references('id')->on('departamento_hospital');
            $table->foreign('areaId')->references('id')->on('area');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicio');
    }
};
