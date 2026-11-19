<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SocialPlatform extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'base_url',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Enlaces de esta plataforma (en cualquier modelo).
     */
    public function socialLinks()
    {
        return $this->hasMany(SocialLink::class);
    }

    /**
     * Genera un slug único a partir del nombre.
     */
    public static function generateSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $count = 1;

        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }
}