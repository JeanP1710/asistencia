<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Personal extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_dni',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'telefono',
        'cargo',
        'tipo_trabajador_id',
        'email',
    ];
    
    public function tipo_trabajador(): BelongsTo
    {
        return $this->belongsTo(TipoTrabajador::class, 'tipo_trabajador_id');
    }
        public function cargo(): BelongsTo
    {
        return $this->belongsTo(Cargo::class, 'cargo');
    }
    
}
