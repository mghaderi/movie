<?php

namespace App\Domains\Person\Services;

use App\Domains\Media\Models\Link;
use App\Domains\Person\Models\Person;
use App\Domains\Person\Models\PersonDetail;
use App\Domains\Word\Models\Word;
use App\Exceptions\ModelTypeException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @property Person|null $person
 */
class PersonService {

    public ?Person $person = null;

    public function __construct(?Person $person = null) {
        $this->person = $person;
    }

    public function setFirstNameWord(Word $word) {
        if ($this->person instanceof Person) {
            $this->person->first_name_word_id  = $word->id;
            return;
        }
        throw new ModelNotFoundException('model person not found');
    }

    public function setLastNameWord(Word $word) {
        if ($this->person instanceof Person) {
            $this->person->last_name_word_id  = $word->id;
            return;
        }
        throw new ModelNotFoundException('model person not found');
    }

    public function setFullNameWord(Word $word) {
        if ($this->person instanceof Person) {
            $this->person->full_name_word_id = $word->id;
            return;
        }
        throw new ModelNotFoundException('model person not found');
    }


}
