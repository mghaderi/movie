<?php

namespace App\Domains\Media\Services;

use App\Domains\Media\Models\MediaDetailDatum;
use App\Domains\Media\Models\MediaDetailRelation;
use App\Domains\Media\Models\MediaDetailRelationDatum;
use App\Exceptions\CanNotSaveModelException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MediaDetailRelationDatumService {

    public ?MediaDetailRelationDatum $mediaDetailRelationDatum = null;

    public function setMediaDetailRelationDatum(MediaDetailRelationDatum $mediaDetailRelationDatum): void {
        $this->mediaDetailRelationDatum = $mediaDetailRelationDatum;
    }

    public function saveMediaDetailRelationDatum(): void {
        if ($this->mediaDetailRelationDatum instanceof MediaDetailRelationDatum) {
            try {
                $this->mediaDetailRelationDatum->saveOrFail();
                return;
            } catch (\Exception|\Throwable $exception) {
                throw new CanNotSaveModelException('media detail relation datum model can not be saved. attributes: ' .
                    implode(',', $this->mediaDetailRelationDatum->getAttributes()));
            }
        }
        throw new ModelNotFoundException('can not find media detail relation datum model');
    }

    public function fetchOrCreateMediaDetailRelationDatum(): MediaDetailRelationDatum {
        if ($this->mediaDetailRelationDatum instanceof MediaDetailRelationDatum) {
            return $this->mediaDetailRelationDatum;
        }
        return (new MediaDetailRelationDatum());
    }

    public function setMediaDetailRelation(MediaDetailRelation $mediaDetailRelation): void {
        if (empty($mediaDetailRelation->id)) {
            throw new ModelNotFoundException('can not find media detail relation model');
        }
        if ($this->mediaDetailRelationDatum instanceof MediaDetailRelationDatum) {
            $this->mediaDetailRelationDatum->media_detail_relation_id = $mediaDetailRelation->id;
            return;
        }
        throw new ModelNotFoundException('can not find media detail relation datum model');
    }

    public function setMediaDetailDatum(MediaDetailDatum $mediaDetailDatum): void {
        if (empty($mediaDetailDatum->id)) {
            throw new ModelNotFoundException('can not find media detail datum model');
        }
        if ($this->mediaDetailRelationDatum instanceof MediaDetailRelationDatum) {
            $this->mediaDetailRelationDatum->media_detail_datum_id = $mediaDetailDatum->id;
            return;
        }
        throw new ModelNotFoundException('can not find media detail relation datum model');
    }

}
