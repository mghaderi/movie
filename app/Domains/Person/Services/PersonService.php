<?php

namespace App\Domains\Person\Services;

use App\Domains\Person\Models\Person;
use App\Domains\Word\Models\Word;
use App\Exceptions\CanNotSaveModelException;
use App\Exceptions\DuplicateModelException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection as SupportCollection;

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

    public function checkForDuplicateFullNameWord(): void {
        if ($this->person instanceof Person) {
            $person = Person::where('full_name_word_id', $this->person->full_name_word_id);
            if (! empty($this->person->id)) {
                $person->where('full_name_word_id', '!=', $this->person->full_name_word_id);
            }
            $person = $person->first();
            if (! empty($person)) {
                throw new DuplicateModelException('person model with same full name word id:' .
                    $this->fetchOrCreatePerson()->full_name_word_id . 'already existed'
                );
            }
            return;
        }
        throw new ModelNotFoundException('model person not found');
    }

    public function fetchPersonWithFullNameWord(Word $fullNameWord): Person {
        if (empty($fullNameWord->id)) {
            throw new ModelNotFoundException('model word not found');
        }
        $person = Person::where('full_name_word_id', $fullNameWord->id)->first();
        if (empty($person)) {
            throw new ModelNotFoundException('model person not found');
        }
        return $person;
    }

    public function fetchRelations(): SupportCollection {
        if ($this->person instanceof Person) {
            $response = collect([]);
            foreach ($this->person->words as $word) {
                $response[] = $word;
            }
            foreach ($this->person->links as $link) {
                $response[] = $link;
            }
            return $response;
        }
        throw new ModelNotFoundException('model person not found');
    }

}
