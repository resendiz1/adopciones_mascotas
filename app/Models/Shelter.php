<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shelter extends Model
{
    protected $fillable = ['user_id', 'name', 'description', 'address', 'ciudad', 'estado', 'phone', 'status'];

    protected function casts(): array
    {
        return [
            'status' => 'string',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mascotas(): HasMany
    {
        return $this->hasMany(Mascota::class, 'refugio_id');
    }
}
