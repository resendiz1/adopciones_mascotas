<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eventos_medicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mascota_id')->constrained()->cascadeOnDelete();
            $table->date('fecha')->nullable();
            $table->string('tipo');
            $table->string('titulo_evento');
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos_medicos');
    }
};
