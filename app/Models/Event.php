<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

protected $fillable = [
    'user_id',
    'event_type_id',
    'venue_id',
    'title',
    'slug',
    'description',
    'city_id',
    'address',
    'starts_at',
    'ends_at',
    'cover',
    'published',
];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'published' => 'boolean',
    ];

    /**
     * Usuario que publicó el evento.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Ciudad donde se celebra el evento.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Genera un slug único a partir del título.
     */
    public static function generateSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
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

    /**
     * URL pública de la portada, o null si no tiene.
     */
    public function coverUrl(): ?string
    {
        if ($this->cover && Storage::disk('public')->exists($this->cover)) {
            return Storage::disk('public')->url($this->cover);
        }

        return null;
    }

    /**
 * Tipo de evento (recital, fiesta, obra de teatro, etc.).
 */
    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }
    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}