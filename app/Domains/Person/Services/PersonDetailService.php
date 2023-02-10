<?php

namespace App\Domains\Person\Services;

use App\Domains\Media\Models\Link;
use App\Domains\Media\Services\LinkService;
use App\Domains\Person\Models\Person;
use App\Domains\Person\Models\PersonDetail;
use App\Domains\Word\Models\Word;
use App\Domains\Word\Services\WordService;
use App\Exceptions\CanNotDeleteModelException;
use App\Exceptions\CanNotSaveModelException;
use App\Exceptions\DuplicateModelException;
use App\Exceptions\InvalidTypeException;
use App\Exceptions\ModelTypeException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

/**
 * @property PersonDetail|null $personDetail
 */
class PersonDetailService {

    const TYPE_PORTRAIT = 'portrait';
    const TYPE_DESCRIPTION = 'description';

    public ?PersonDetail $personDetail = null;

    public function setPersonDetail(PersonDetail $personDetail) {
        $this->personDetail = $personDetail;
    }

    public function savePersonDetail(): void {
        if ($this->personDetail instanceof PersonDetail) {
            try {
                $this->personDetail->saveOrFail();
                return;
            } catch (\Exception|\Throwable $exception) {
                throw new CanNotSaveModelException(
                    'person detail model can not be saved. attributes: ' .
                    implode(',', $this->personDetail->getAttributes())
                );
            }
        }
        throw new ModelNotFoundException('model person detail not found');
    }

    public function fetchOrCreatePersonDetail(): PersonDetail {
        if ($this->personDetail instanceof PersonDetail) {
            return $this->personDetail;
        }
        return (new PersonDetail());
    }

    public function personDetailTypesRelations(): array {
        return [
            self::TYPE_PORTRAIT => Link::class,
            self::TYPE_DESCRIPTION => Word::class
        ];
    }

    public function setPerson(Person $person): void {
        if ($this->personDetail instanceof PersonDetail) {
            $this->personDetail->person_id = $person->id;
            return;
        }
        throw new ModelNotFoundException('model person detail not found');
    }

    public function setRelation(Model $relation, string $type): void {
        if ($this->personDetail instanceof PersonDetail) {
            $personDetailClass = $this->personDetailTypesRelations()[$type] ?? '';
            if ($personDetailClass === get_class($relation)) {
                $this->personDetail->type = $type;
                $this->personDetail->relation_type = $this->personDetail->possibleMorphs[$personDetailClass];
                $this->personDetail->relation_id = $relation->id;
                return;
            }
            throw new ModelTypeException('class ' . get_class($relation) . ' or type' . $type . ' not expected for person detail relation');
        }
        throw new ModelNotFoundException('model person detail not found');
    }

    public function checkForDuplicate(): void {
        if (! $this->personDetail instanceof PersonDetail) {
            throw new ModelNotFoundException('model person detail not found');
        }
        $relation = $this->personDetail->relation;
        if (empty($relation)) {
            throw new ModelNotFoundException(
                'model relation of person detail not found'
            );
        }
        if (empty($this->personDetail->type)) {
            throw new InvalidTypeException('type of person detail can not be empty');
        }
        if (empty($this->personDetail->person_id)) {
            throw new ModelNotFoundException('model person of person detail not found');
        }
        $duplicate = PersonDetail::where('relation_id', $this->personDetail->relation_id)
            ->where('relation_type', $this->personDetail->relation_type)
            ->where('type', $this->personDetail->type)
            ->where('person_id', $this->personDetail->person_id);
        if (!empty($this->personDetail->id)) {
            $duplicate->where('id', '!=', $this->personDetail->id);
        }
        $duplicate = $duplicate->first();
        if (!empty($duplicate)) {
            throw new DuplicateModelException('person detail model already exited');
        }
        return;
    }

    public function fetchRelationSerices(): array {
        return [
            Link::class => LinkService::class,
            Word::class => WordService::class,
        ];
    }

    public function removeRelation(Person $person, Model $relation): void {
        if (empty ($person->id)) {
            throw new ModelNotFoundException('model person not found');
        }
        if (empty($relation->id)) {
            throw new ModelNotFoundException('model relation for person detail not found');
        }
        $presonDetail = PersonDetail::where('person_id', $person->id)
            ->where('relation_id', $relation->id)
            ->where('relation_type', $relation->morphName)
            ->first();
        if (empty($presonDetail)) {
            throw new ModelNotFoundException('model person detail not found');
        }
        DB::beginTransaction();
        if (count($relation->morphLinks) <= 1) {
            $serviceClass = $this->fetchRelationSerices()[get_class($relation)];
            $service = new $serviceClass();
            $service->remove($relation);
        }
        if (! $presonDetail->delete()) {
            throw new CanNotDeleteModelException(
                'can not delete model person detail with id: '. $presonDetail->id
            );
        }
        DB::commit();
        return;
    }
}
