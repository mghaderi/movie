<?php

namespace App\Domains\Person\Services\Factories;

use App\Domains\Person\Models\Person;

class PersonFactory
{
    public function generate(): Person {
        /** @todo */
        return new Person();
    }
}
