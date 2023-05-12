<?php

namespace App\Domains\Media\Services\Factories;

use App\Domains\Media\Models\Media;
use App\Domains\Media\Services\Factories\DTOs\MediaFactoryData;
use App\Domains\Media\Services\MediaService;

class MediaFactory {

    public function generate(MediaFactoryData $mediaFactoryData): Media {

        return new Media();
        // $mediaService = new MediaService();
        // $media = $mediaService->fetchMedias(ttName: $ttName)->first();
        // if (empty($media)) {
        //     $media = $mediaService->fetchOrCreateMedia();
        // }
        // $mediaService->setMedia($media);
        // $mediaService->setMediaData($ttName, $type);
        // $mediaService->saveMedia();
        // return $mediaService->fetchOrCreateMedia();
    }
}
