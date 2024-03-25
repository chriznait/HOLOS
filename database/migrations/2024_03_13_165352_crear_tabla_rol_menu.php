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
        Schema::create('rol_menu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rolId');
            $table->unsignedBigInteger('menuId');
            $table->boolean('ver')->default(0);
            $table->boolean('crear')->default(0);
            $table->boolean('editar')->default(0);
            $table->boolean('eliminar')->default(0);
            $table->timestamps();

            $table->foreign('rolId')->references('id')->on('roles');
            $table->foreign('menuId')->references('id')->on('menu');

            $table->unique(['rolId', 'menuId']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rol_menu');
    }
};
