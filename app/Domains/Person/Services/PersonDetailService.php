<?php

namespace App\Domains\Person\Services;

use App\Domains\Person\Models\Person;
use App\Domains\Person\Models\PersonDetail;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @property PersonDetail|null $personDetail
 */
class PersonDetailService {

    const TYPE_PORTRAIT = 'portrait';
    const TYPE_DESCRIPTION = 'description';

    public ?PersonDetail $personDetail = null;

    public function __construct(?PersonDetail $personDetail = null)
    {
        $this->personDetail = $personDetail;
    }

    public function personDetailTypes(): array {
        return [
            self::TYPE_PORTRAIT => self::TYPE_PORTRAIT,
            self::TYPE_DESCRIPTION => self::TYPE_DESCRIPTION
        ];
    }

    public function setPerson(Person $person): void {
        if ($this->personDetail instanceof PersonDetail) {
            $this->personDetail->person_id = $person->id;
            return;
        }
        throw new ModelNotFoundException('model person detail not found');
    }

    /** @todo  */
//    public function setType(string $type): void {
//        if ($this->personDetail instanceof PersonDetail) {
//            $this->personDetail->person_id = $person->id;
//            return;
//        }
//        throw new ModelNotFoundException('model person detail not found');
//    }

}
