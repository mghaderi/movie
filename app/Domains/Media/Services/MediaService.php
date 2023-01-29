<?php

namespace App\Domains\Media\Services;

use App\Domains\Media\Models\Media;

class MediaService
{
    public Media|null $media;

    public function __construct(Media|null $media = null) {
        $this->media = $media;
    }

    public function mediaTypes(): array {
        return [
            'movies',
            'animations',
            'series'
        ];
    }


}
