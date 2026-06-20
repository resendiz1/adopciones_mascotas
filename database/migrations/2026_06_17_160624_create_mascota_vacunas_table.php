<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mascota_vacunas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mascota_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vacuna_id')->constrained()->cascadeOnDelete();
            $table->date('fecha_aplicacion')->nullable();
            $table->date('proxima_dosis')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mascota_vacunas');
    }
};
