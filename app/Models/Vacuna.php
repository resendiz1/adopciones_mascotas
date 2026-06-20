<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vacuna extends Model
{
    protected $table = 'vacunas';

    protected $fillable = ['nombre', 'descripcion'];

    public function mascotaVacunas(): HasMany
    {
        return $this->hasMany(MascotaVacuna::class);
    }
}
