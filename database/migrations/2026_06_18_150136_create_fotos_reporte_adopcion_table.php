<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fotos_reporte_adopcion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporte_id')->constrained('reportes_adopcion')->cascadeOnDelete();
            $table->string('url');
            $table->string('tipo')->default('foto');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fotos_reporte_adopcion');
    }
};
