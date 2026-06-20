<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MascotaVacuna extends Model
{
    protected $table = 'mascota_vacunas';

    protected $fillable = [
        'mascota_id',
        'vacuna_id',
        'fecha_aplicacion',
        'proxima_dosis',
        'notas',
    ];

    protected function casts(): array
    {
        return [
            'fecha_aplicacion' => 'date',
            'proxima_dosis' => 'date',
        ];
    }

    public function mascota(): BelongsTo
    {
        return $this->belongsTo(Mascota::class);
    }

    public function vacuna(): BelongsTo
    {
        return $this->belongsTo(Vacuna::class);
    }
}
