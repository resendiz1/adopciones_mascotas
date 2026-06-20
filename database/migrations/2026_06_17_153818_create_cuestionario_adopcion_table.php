<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cuestionario_adopcion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitud_adopcion_id')->constrained('solicitudes_adopcion')->cascadeOnDelete();
            $table->string('tipo_vivienda');
            $table->boolean('tiene_patio')->default(false);
            $table->boolean('otras_mascotas')->default(false);
            $table->integer('miembros_familia');
            $table->text('experiencia_con_mascotas');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuestionario_adopcion');
    }
};
