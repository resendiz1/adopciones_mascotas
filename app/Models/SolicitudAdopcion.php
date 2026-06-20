<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SolicitudAdopcion extends Model
{
    protected $table = 'solicitudes_adopcion';

    protected $fillable = ['mascota_id', 'user_id', 'status', 'mensaje', 'motivo_rechazo'];

    protected function casts(): array
    {
        return [
            'status' => 'string',
        ];
    }

    public function mascota(): BelongsTo
    {
        return $this->belongsTo(Mascota::class);
    }

    public function adoptante(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cuestionario(): HasOne
    {
        return $this->hasOne(CuestionarioAdopcion::class, 'solicitud_adopcion_id');
    }

    public function adopcion(): HasOne
    {
        return $this->hasOne(Adopcion::class, 'solicitud_adopcion_id');
    }
}
