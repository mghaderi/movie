<?php

namespace Tests\Feature\Person\Services;

use App\Domains\Person\Models\Person;
use App\Domains\Person\Services\PersonService;
use App\Domains\Word\Models\Word;
use App\Exceptions\DuplicateModelException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonServiceTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function set_person_test() {
        $personService = new PersonService();
        $this->assertEmpty($personService->person);
        $personService->setPerson(Person::factory()->create());
        $this->assertTrue($personService->person instanceof Person);
    }

    /** @test */
    public function save_person_test() {
        $personService = new PersonService();
        try {
            $personService->savePerson();
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $personService->person = Person::factory()->create();
        try {
            $personService->savePerson();
            $this->assertNotEmpty($personService->person->id);
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function fetch_or_create_person_test() {
        $personService = new PersonService();
        $this->assertEmpty($personService->fetchOrCreatePerson()->id);;
        $personService->person = Person::factory()->create();
        $this->assertTrue($personService->fetchOrCreatePerson()->id === $personService->person->id);
    }

    /** @test */
    public function set_first_name_word_test() {
        $personService = new PersonService();
        $word = Word::factory()->create();
        try {
            $personService->setFirstNameWord($word);
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $personService->person = Person::factory()->create();
        try {
            $personService->setFirstNameWord($word);
            $this->assertTrue($word->id === $personService->person->first_name_word_id);
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function set_last_name_word_test() {
        $personService = new PersonService();
        $word = Word::factory()->create();
        try {
            $personService->setLastNameWord($word);
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $personService->person = Person::factory()->create();
        try {
            $personService->setLastNameWord($word);
            $this->assertTrue($word->id === $personService->person->last_name_word_id);
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function set_full_name_word_test() {
        $personService = new PersonService();
        $word = Word::factory()->create();
        try {
            $personService->setFullNameWord($word);
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $personService->person = Person::factory()->create();
        try {
            $personService->setFullNameWord($word);
            $this->assertTrue($personService->person->full_name_word_id === $word->id);
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function check_for_duplicate_full_name_test() {
        $personService = new PersonService();
        $word = Word::factory()->create();
        $person = Person::factory()->create(['full_name_word_id' => $word->id]);
        $personService->setPerson($person);
        try {
            $personService->checkForDuplicateFullNameWord();
        } catch (DuplicateModelException $exception) {
            $this->fail();
        }
        $person2 = new Person(['full_name_word_id' => $word->id]);
        $personService->setPerson($person2);
        try {
            $personService->checkForDuplicateFullNameWord();
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof DuplicateModelException);
        }
    }

    /** @test */
    public function fetch_person_with_full_name_word_test() {
        $personService = new PersonService();
        try {
            $personService->fetchPersonWithFullNameWord(new Word());
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $word = Word::factory()->create();
        $person = Person::factory()->create(['full_name_word_id' => $word->id]);;
        try {
            $personService->fetchPersonWithFullNameWord($person);
        } catch (\Exception $exception) {
            $this->fail();
        }

    }

}
