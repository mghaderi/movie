<?php

namespace App\Domains\Person\Services;

use App\Domains\Person\Models\PersonDetail;

/**
 * @property PersonDetail|null $personDetail
 */
class PersonDetailService {

    public PersonDetail|null $personDetail;

    public function __construct(PersonDetail|null $personDetail = null)
    {
        $this->personDetail = $personDetail;
    }

    public function personDetailTypes(): array {
        return [
            'portrait',
            'description'
        ];
    }
}
