<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Adopcion extends Model
{
    protected $table = 'adopciones';

    protected $fillable = [
        'solicitud_adopcion_id',
        'mascota_id',
        'adoptante_user_id',
        'refugio_id',
        'fecha_aprobacion',
        'fecha_entrega',
        'status',
        'notas',
    ];

    protected function casts(): array
    {
        return [
            'fecha_aprobacion' => 'datetime',
            'fecha_entrega' => 'datetime',
        ];
    }

    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(SolicitudAdopcion::class, 'solicitud_adopcion_id');
    }

    public function mascota(): BelongsTo
    {
        return $this->belongsTo(Mascota::class);
    }

    public function adoptante(): BelongsTo
    {
        return $this->belongsTo(User::class, 'adoptante_user_id');
    }

    public function shelter(): BelongsTo
    {
        return $this->belongsTo(Shelter::class, 'refugio_id');
    }

    public function visitas(): HasMany
    {
        return $this->hasMany(SeguimientoVisitaAdopcion::class);
    }

    public function reportes(): HasMany
    {
        return $this->hasMany(ReporteAdopcion::class);
    }
}
