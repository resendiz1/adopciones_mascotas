<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReporteAdopcion extends Model
{
    protected $table = 'reportes_adopcion';

    protected $fillable = [
        'adopcion_id',
        'adoptante_id',
        'mascota_id',
        'status',
        'descripcion_reporte',
    ];

    public function adopcion(): BelongsTo
    {
        return $this->belongsTo(Adopcion::class);
    }

    public function adoptante(): BelongsTo
    {
        return $this->belongsTo(User::class, 'adoptante_id');
    }

    public function mascota(): BelongsTo
    {
        return $this->belongsTo(Mascota::class);
    }

    public function fotos(): HasMany
    {
        return $this->hasMany(FotoReporteAdopcion::class, 'reporte_id');
    }
}
