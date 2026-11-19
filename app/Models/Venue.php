<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Concerns\HasSocialLinks;

class Venue extends Model
{
    
    use HasFactory, HasSocialLinks;

    protected $fillable = [
        'name',
        'slug',
        'address',
        'city_id',
        'latitude',
        'longitude',
        'description',
        'cover',
        'gallery',
    ];

    protected $casts = [
        'gallery' => 'array',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

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

    public function coverUrl(): ?string
    {
        if ($this->cover && Storage::disk('public')->exists($this->cover)) {
            return Storage::disk('public')->url($this->cover);
        }

        return null;
    }

    /**
     * URLs públicas de la galería.
     */
    public function galleryUrls(): array
    {
        if (!$this->gallery) {
            return [];
        }

        return collect($this->gallery)
            ->filter(fn ($path) => Storage::disk('public')->exists($path))
            ->map(fn ($path) => Storage::disk('public')->url($path))
            ->values()
            ->toArray();
    }
}