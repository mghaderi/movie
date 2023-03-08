<?php

namespace App\Domains\Media\Services;

use App\Domains\Media\Models\Media;
use App\Exceptions\CanNotSaveModelException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;

class MediaService {

    public ?Media $media = null;

    public function setMedia(Media $media): void {
        $this->media = $media;
    }

    public function fetchOrCreateMedia(): Media {
        if ($this->media instanceof Media) {
            return $this->media;
        }
        return (new Media());
    }

    public function setMediaData(string $ttName, string $type): void {
        if ($this->media instanceof Media) {
            $this->media->tt_name = $ttName;
            $this->media->type = $type;
            return;
        }
        throw new ModelNotFoundException('model media not found');
    }

    public function saveMedia(): void {
        if ($this->media instanceof Media) {
            try {
                $this->media->saveOrFail();
                return;
            } catch (\Exception|\Throwable $exception) {
                throw new CanNotSaveModelException('model media can not be saved: ' . $exception->getMessage());
            }
        }
        throw new ModelNotFoundException('model media not found');
    }

    public function fetchMedias(?string $ttName = null, ?string $type = null): Collection {
        return Media::filter($ttName, $type)->get();
    }
}
