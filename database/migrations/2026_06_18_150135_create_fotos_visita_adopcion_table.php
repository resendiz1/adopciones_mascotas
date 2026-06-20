<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fotos_visita_adopcion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visita_id')->constrained('seguimiento_visita_adopcion')->cascadeOnDelete();
            $table->string('url');
            $table->string('tipo')->default('foto');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fotos_visita_adopcion');
    }
};
