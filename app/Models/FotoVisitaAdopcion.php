<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FotoVisitaAdopcion extends Model
{
    protected $table = 'fotos_visita_adopcion';

    protected $fillable = ['visita_id', 'url', 'tipo', 'descripcion'];

    public function visita(): BelongsTo
    {
        return $this->belongsTo(SeguimientoVisitaAdopcion::class, 'visita_id');
    }
}
