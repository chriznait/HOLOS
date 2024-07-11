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
        Schema::create('marcaciones_detalle', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('marcacionId');
            $table->integer('codigo');
            $table->string('nombre');
            $table->dateTime('marcacion');
            $table->string('punto');
            $table->timestamps();

            $table->foreign('marcacionId')->references('id')->on('marcaciones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marcaciones_detalle');
    }
};
