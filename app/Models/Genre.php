<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Usuarios que tienen este género entre sus gustos.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}