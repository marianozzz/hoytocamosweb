<?php

namespace App\Models;

use App\Models\Concerns\HasSocialLinks;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Band extends Model
{
    use HasFactory, HasSocialLinks;

    protected $fillable = [
        'user_id',
        'entity_type_id',
        'country_id',
        'province_id',
        'city_id',
        'name',
        'slug',
        'bio',
        'founded_at',
        'cover',
        'gallery',
        'status',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'gallery' => 'array',
        'approved_at' => 'datetime',
        'founded_at' => 'date',
    ];

    /**
     * Usuario que creó la banda.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Usuario que aprobó la banda.
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Tipo de entidad (banda, artista solista, pintor, etc.).
     */
    public function entityType()
    {
        return $this->belongsTo(EntityType::class);
    }

    /**
     * País de origen.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Provincia de origen.
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Ciudad de origen.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Géneros o disciplinas que practica.
     */
    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    /**
     * Integrantes de la banda (con su rol).
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'band_member')
            ->withPivot('role')
            ->withTimestamps();
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

    /**
     * ¿Está aprobada?
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }
}