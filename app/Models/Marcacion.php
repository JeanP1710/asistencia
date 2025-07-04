<?php

namespace App\Models;

use App\Http\Traits\MarcacionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Marcacion extends Model
{
    use HasFactory, MarcacionTrait;
    protected $fillable=['personal_id', 'sede_id','fecha', 'hora', 'tipo'];
    /**
     * Get the alumno that owns the Marcacion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function personal(): BelongsTo
    {
        return $this->belongsTo(Personal::class, 'personal_id');
    }
    /**
     * Get the establecimiento that owns the Marcacion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

}
