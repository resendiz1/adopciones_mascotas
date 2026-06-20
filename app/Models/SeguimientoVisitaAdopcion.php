<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SeguimientoVisitaAdopcion extends Model
{
    protected $table = 'seguimiento_visita_adopcion';

    protected $fillable = [
        'adopcion_id',
        'user_refugio_id',
        'fecha_programada',
        'fecha_realizada',
        'tipo',
        'status',
        'notas',
    ];

    protected function casts(): array
    {
        return [
            'fecha_programada' => 'date',
            'fecha_realizada' => 'date',
        ];
    }

    public function adopcion(): BelongsTo
    {
        return $this->belongsTo(Adopcion::class);
    }

    public function refugio(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_refugio_id');
    }

    public function fotos(): HasMany
    {
        return $this->hasMany(FotoVisitaAdopcion::class, 'visita_id');
    }
}
