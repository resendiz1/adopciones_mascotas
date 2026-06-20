<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FotoReporteAdopcion extends Model
{
    protected $table = 'fotos_reporte_adopcion';

    protected $fillable = ['reporte_id', 'url', 'tipo'];

    public function reporte(): BelongsTo
    {
        return $this->belongsTo(ReporteAdopcion::class, 'reporte_id');
    }
}
