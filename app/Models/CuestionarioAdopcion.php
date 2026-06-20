<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CuestionarioAdopcion extends Model
{
    protected $table = 'cuestionario_adopcion';

    protected $fillable = [
        'solicitud_adopcion_id',
        'tipo_vivienda',
        'tiene_patio',
        'otras_mascotas',
        'miembros_familia',
        'experiencia_con_mascotas',
    ];

    protected function casts(): array
    {
        return [
            'tiene_patio' => 'boolean',
            'otras_mascotas' => 'boolean',
            'miembros_familia' => 'integer',
        ];
    }

    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(SolicitudAdopcion::class, 'solicitud_adopcion_id');
    }
}
