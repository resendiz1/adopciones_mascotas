<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Mascota extends Model
{
    protected $fillable = [
        'refugio_id',
        'nombre',
        'especie',
        'raza',
        'edad_meses',
        'sexo',
        'tamano',
        'peso',
        'descripcion',
        'esterilizado',
        'desparasitado',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'edad_meses' => 'integer',
            'peso' => 'decimal:2',
            'esterilizado' => 'boolean',
            'desparasitado' => 'boolean',
        ];
    }

    public function shelter(): BelongsTo
    {
        return $this->belongsTo(Shelter::class, 'refugio_id');
    }

    public function fotoPrincipal(): HasOne
    {
        return $this->hasOne(FotoMascota::class, 'mascota_id')->where('is_primary', true);
    }

    public function favoritos(): HasMany
    {
        return $this->hasMany(Favorito::class);
    }

    public function solicitudes(): HasMany
    {
        return $this->hasMany(SolicitudAdopcion::class);
    }

    public function solicitudPendiente(): HasOne
    {
        return $this->hasOne(SolicitudAdopcion::class)->where('status', 'pendiente');
    }

    public function vacunas(): HasMany
    {
        return $this->hasMany(MascotaVacuna::class);
    }

    public function eventosMedicos(): HasMany
    {
        return $this->hasMany(EventoMedico::class);
    }
}
