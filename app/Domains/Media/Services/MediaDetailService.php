<?php

namespace App\Domains\Media\Services;

use App\Domains\Media\Models\MediaDetail;

class MediaDetailService
{
    public MediaDetail|null $mediaDetail;

    public function __construct(MediaDetail|null $mediaDetail = null) {
        $this->mediaDetail = $mediaDetail;
    }

    public function mediaDetailTypes(): array {
        return [
            'colaborator',
            'source',
            'cover',
            'trailer',
            'location',
            'genre',
            'language',
            'release',
            'rate',
            'other',
        ];
    }


}
