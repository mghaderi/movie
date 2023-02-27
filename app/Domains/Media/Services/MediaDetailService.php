<?php

namespace App\Domains\Media\Services;

use App\Domains\Media\Models\Media;
use App\Domains\Media\Models\MediaDetail;
use App\Exceptions\CanNotSaveModelException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MediaDetailService
{
    public ?MediaDetail $mediaDetail = null;

    public function setMediaDetail(MediaDetail $mediaDetail): void {
        $this->mediaDetail = $mediaDetail;
    }

    public function fetchOrCreateMediaDetail(): MediaDetail {
        if ($this->mediaDetail instanceof MediaDetail) {
            return $this->mediaDetail;
        }
        return (new MediaDetail());
    }

    public function setMedia(Media $media): void {
        if (empty($media->id)) {
            throw new ModelNotFoundException('model media not found');
        }
        if ($this->mediaDetail instanceof MediaDetail) {
            $this->mediaDetail->media_id = $media->id;
            return;
        }
        throw new ModelNotFoundException('model media detail not found');
    }

    public function setMediaDetailData(string $type): void {
        if ($this->mediaDetail instanceof MediaDetail) {
            $this->mediaDetail->type = $type;
            return;
        }
        throw new ModelNotFoundException('model media detail not found');
    }

    public function saveMediaDetail(): void {
        if ($this->mediaDetail instanceof MediaDetail) {
            try {
                if (!$this->mediaDetail->save()) {
                    throw new CanNotSaveModelException('model media detail can not be saved.');
                }
                return;
            } catch (\Exception|\Throwable $exception) {
                throw new CanNotSaveModelException('model media detail can not be saved: ' . $exception->getMessage());
            }
        }
        throw new ModelNotFoundException('model media detail not found');
    }
}
