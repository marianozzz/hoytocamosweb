<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = [
        'country_id',
        'name',
    ];

    /**
     * País al que pertenece esta provincia.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Ciudades de esta provincia.
     */
    public function cities()
    {
        return $this->hasMany(City::class);
    }

    /**
     * Usuarios que viven en esta provincia.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
