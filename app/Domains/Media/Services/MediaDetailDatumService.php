<?php

namespace App\Domains\Media\Services;

use App\Domains\Media\Models\MediaDetail;
use App\Domains\Media\Models\MediaDetailDatum;
use App\Exceptions\CanNotSaveModelException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MediaDetailDatumService {
    public ?MediaDetailDatum $mediaDetailDatum = null;

    public function setMediaDetailDatum(MediaDetailDatum $mediaDetailDatum): void {
        $this->mediaDetailDatum = $mediaDetailDatum;
    }

    public function saveMediaDetailDatum(): void {
        if ($this->mediaDetailDatum instanceof MediaDetailDatum) {
            try {
                $this->mediaDetailDatum->saveOrFail();
                return;
            } catch (\Exception|\Throwable $exception) {
                throw new CanNotSaveModelException('media detail datum model can not be saved. attributes: ' .
                    implode(',', $this->mediaDetailDatum->getAttributes()));
            }
        }
        throw new ModelNotFoundException('model media detail datum not found');
    }

    public function fetchOrCreateMediaDetailDatum(): MediaDetailDatum {
        if ($this->mediaDetailDatum instanceof MediaDetailDatum) {
            return $this->mediaDetailDatum;
        }
        return (new MediaDetailDatum());
    }

    public function setMediaDetail(MediaDetail $mediaDetail): void {
        if ($this->mediaDetailDatum instanceof MediaDetailDatum) {
            $this->mediaDetailDatum->media_detail_id = $mediaDetail->id;
            return;
        }
        throw new ModelNotFoundException('model media detail datum not found');
    }

    public function setData(string $name, string $value): void {
        if ($this->mediaDetailDatum instanceof MediaDetailDatum) {
            $this->mediaDetailDatum->name = $name;
            $this->mediaDetailDatum->value = $value;
            return;
        }
        throw new ModelNotFoundException('model media detail datum not found');
    }
}
