<?php

namespace App\Domains\Person\Services;

use App\Domains\Person\Models\Person;
use App\Domains\Word\Models\Word;
use App\Exceptions\CanNotSaveModelException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @property Person|null $person
 */
class PersonService {

    public ?Person $person = null;

    public function setPerson(Person $person): void {
        $this->person = $person;
    }

    public function savePerson(): void {
        if ($this->person instanceof Person) {
            try {
                $this->person->saveOrFail();
                return;
            } catch (\Exception|\Throwable $exception) {
                throw new CanNotSaveModelException('person model can not be saved. attributes: ' . implode(',', $this->person->getAttributes()));
            }
        }
        throw new ModelNotFoundException('model person not found');
    }

    public function fetchOrCreatePerson(): Person {
        if ($this->person instanceof Person) {
            return $this->person;
        }
        return (new Person());
    }

    public function setFirstNameWord(Word $word): void {
        if ($this->person instanceof Person) {
            $this->person->first_name_word_id  = $word->id;
            return;
        }
        throw new ModelNotFoundException('model person not found');
    }

    public function setLastNameWord(Word $word): void {
        if ($this->person instanceof Person) {
            $this->person->last_name_word_id  = $word->id;
            return;
        }
        throw new ModelNotFoundException('model person not found');
    }

    public function setFullNameWord(Word $word): void {
        if ($this->person instanceof Person) {
            $this->person->full_name_word_id = $word->id;
            return;
        }
        throw new ModelNotFoundException('model person not found');
    }


}
