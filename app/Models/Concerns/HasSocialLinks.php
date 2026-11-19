<?php

namespace App\Models\Concerns;

use App\Models\SocialLink;

trait HasSocialLinks
{
    /**
     * Enlaces de redes sociales del modelo.
     */
    public function socialLinks()
    {
        return $this->morphMany(SocialLink::class, 'linkable');
    }
}