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
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('routeName', 150)->unique();
            $table->string('slug')->unique();
            $table->string('icon', 50);
            $table->unsignedBigInteger('parentId')->nullable()->default(null);
            $table->smallInteger('order')->default(0);
            $table->boolean('enabled')->default(1);
            $table->timestamps();

            $table->foreign('parentid')->references('id')->on('menu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
