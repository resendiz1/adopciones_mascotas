<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refugio_id')->constrained('shelters')->cascadeOnDelete();
            $table->string('nombre');
            $table->string('especie');
            $table->string('raza')->nullable();
            $table->unsignedInteger('edad_meses')->nullable();
            $table->string('sexo');
            $table->string('tamano');
            $table->decimal('peso', 8, 2)->nullable();
            $table->text('descripcion');
            $table->boolean('esterilizado')->default(false);
            $table->boolean('desparasitado')->default(false);
            $table->string('status')->default('disponible');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};
