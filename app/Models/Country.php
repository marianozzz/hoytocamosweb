<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'code',
    ];

    /**
     * Provincias que pertenecen a este país.
     */
    public function provinces()
    {
        return $this->hasMany(Province::class);
    }

    /**
     * Ciudades del país (a través de las provincias).
     */
    public function cities()
    {
        return $this->hasManyThrough(City::class, Province::class);
    }

    /**
     * Usuarios que viven en este país.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}