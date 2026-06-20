<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seguimiento_visita_adopcion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adopcion_id')->constrained('adopciones')->cascadeOnDelete();
            $table->foreignId('user_refugio_id')->constrained('users')->cascadeOnDelete();
            $table->date('fecha_programada')->nullable();
            $table->date('fecha_realizada')->nullable();
            $table->string('tipo')->default('post_adopcion');
            $table->string('status')->default('pendiente');
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seguimiento_visita_adopcion');
    }
};
