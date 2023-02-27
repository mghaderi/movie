<?php

namespace App\Domains\Media\Services;

use App\Domains\Media\Models\MediaDetail;
use App\Domains\Media\Models\MediaDetailRelation;
use App\Exceptions\CanNotSaveModelException;
use App\Exceptions\ModelTypeException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MediaDetailRelationService {

    public ?MediaDetailRelation $mediaDetailRelation = null;

    public function setMediaDetailRelation(MediaDetailRelation $mediaDetailRelation): void {
        $this->mediaDetailRelation = $mediaDetailRelation;
    }

    public function saveMediaDetailRelation(): void {
        if ($this->mediaDetailRelation instanceof MediaDetailRelation) {
            try {
                $this->mediaDetailRelation->saveOrFail();
                return;
            } catch (\Exception|\Throwable $exception) {
                throw new CanNotSaveModelException('media detail relation model can not be saved. attributes: ' .
                    implode(',', $this->mediaDetailRelation->getAttributes()));
            }
        }
        throw new ModelNotFoundException('model media detail relation not found');
    }

    public function fetchOrCreateMediaDetailRelation(): MediaDetailRelation {
        if ($this->mediaDetailRelation instanceof MediaDetailRelation) {
            return $this->mediaDetailRelation;
        }
        return (new MediaDetailRelation());
    }

    public function setMediaDetail(MediaDetail $mediaDetail): void {
        if (empty($mediaDetail->id)) {
            throw new ModelNotFoundException('model media detail not found');
        }
        if ($this->mediaDetailRelation instanceof MediaDetailRelation) {
            $this->mediaDetailRelation->media_detail_id = $mediaDetail->id;
            return;
        }
        throw new ModelNotFoundException('model media detail relation not found');
    }

    public function setRelation(Model $relation): void {
        if ($this->mediaDetailRelation instanceof MediaDetailRelation) {
            if (in_array(get_class($relation), $this->mediaDetailRelation->possibleMorphClasses)) {
                $this->mediaDetailRelation->relation_type = $this->mediaDetailRelation->possibleMorphs[get_class($relation)];
                $this->mediaDetailRelation->relation_id = $relation->id;
                return;
            }
            throw new ModelTypeException('class ' . get_class($relation) . ' not expected for media detail relation relation');
        }
        throw new ModelNotFoundException('model media detail relation not found');
    }
}
