<?php

namespace App\Domains\Person\Services;

use App\Domains\Media\Models\Link;
use App\Domains\Person\Models\Person;
use App\Domains\Person\Models\PersonDetail;
use App\Domains\Word\Models\Word;
use App\Exceptions\CanNotSaveModelException;
use App\Exceptions\InvalidTypeException;
use App\Exceptions\ModelTypeException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
}
