<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'linkable_id',
        'linkable_type',
        'social_platform_id',
        'url',
    ];

    /**
     * Modelo dueño del enlace (User, Venue, Band, etc.).
     */
    public function linkable()
    {
        return $this->morphTo();
    }

    /**
     * Plataforma del enlace (Instagram, Facebook, etc.).
     */
    public function socialPlatform()
    {
        return $this->belongsTo(SocialPlatform::class);
    }
}