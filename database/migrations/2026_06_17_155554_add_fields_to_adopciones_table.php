<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('adopciones', function (Blueprint $table) {
            $table->dateTime('fecha_aprobacion')->nullable()->after('refugio_id');
            $table->dateTime('fecha_entrega')->nullable()->after('fecha_aprobacion');
            $table->string('status')->default('activa')->after('fecha_entrega');
            $table->text('notas')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('adopciones', function (Blueprint $table) {
            $table->dropColumn(['fecha_aprobacion', 'fecha_entrega', 'status', 'notas']);
        });
    }
};
