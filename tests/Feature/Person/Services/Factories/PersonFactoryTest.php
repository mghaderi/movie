<?php

namespace Tests\Feature\Person\Services\Factories;

use App\Domains\Media\Models\Link;
use App\Domains\Person\Models\Person;
use App\Domains\Person\Models\PersonDetail;
use App\Domains\Person\Services\Factories\DTOs\PersonFactoryDTO;
use App\Domains\Person\Services\Factories\PersonFactory;
use App\Domains\Person\Services\PersonDetailService;
use App\Domains\Word\Models\Word;
use App\Exceptions\ModelTypeException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonFactoryTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function generate_test() {
        $personFactory = new PersonFactory();
        $firstName = Word::factory()->create();
        $lastName = Word::factory()->create();
        $fullName = Word::factory()->create();
        $person = $personFactory->generate(
            $firstName,
            $lastName,
            $fullName
        );
        $this->assertNotEmpty($person->id);
        $this->assertTrue($person->firstNameWord instanceof Word);
        $this->assertTrue($person->lastNameWord instanceof Word);
        $this->assertTrue($person->fullNameWord instanceof Word);

        $relationLink1 = Link::factory()->create();
        $relationLink2 = Link::factory()->create();
        $relationWord1 = Word::factory()->create();
        $relationWord2 = Word::factory()->create();
        $person = $personFactory->generate(
            $firstName,
            $lastName,
            $fullName,
            new PersonFactoryDTO([
                'relation' => $relationLink1,
                'type' => PersonDetailService::TYPE_PORTRAIT
            ]),
            new PersonFactoryDTO([
                'relation' => $relationLink2,
                'type' => PersonDetailService::TYPE_PORTRAIT
            ]),
            new PersonFactoryDTO([
                'relation' => $relationWord1,
                'type' => PersonDetailService::TYPE_DESCRIPTION
            ]),
            new PersonFactoryDTO([
                'relation' => $relationWord2,
                'type' => PersonDetailService::TYPE_DESCRIPTION
            ]),
        );
        $personDetailService = new PersonDetailService();
        $this->assertNotEmpty(count($person->personDetails));
        foreach ($person->personDetails as $personDetail) {
            $this->assertTrue($personDetail instanceof PersonDetail);
            $this->assertTrue($personDetail->person_id == $person->id);
            $this->assertTrue(in_array($personDetail->type, array_keys($personDetailService->personDetailTypesRelations())));
            $this->assertTrue($personDetailService->personDetailTypesRelations()[$personDetail->type] == get_class($personDetail->relation));
        }
        $this->assertNotEmpty(count($person->words));
        foreach ($person->words as $word) {
            $this->assertTrue($word instanceof Word);
            $this->assertTrue(in_array($word->id, [$relationWord1->id, $relationWord2->id]));
            $this->assertNotEmpty(count($word->personDetails));
            foreach ($word->personDetails as $personDetail) {
                $this->assertTrue($personDetail instanceof PersonDetail);
                $this->assertTrue($personDetail->person_id == $person->id);
                $this->assertTrue($personDetail->type == PersonDetailService::TYPE_DESCRIPTION);
                $this->assertTrue($personDetail->relation_type == $word->morphName);
                $this->assertTrue($personDetail->relation_id == $word->id);
            }
        }
        $this->assertNotEmpty(count($person->links));
        foreach ($person->links as $link) {
            $this->assertTrue($link instanceof Link);
            $this->assertTrue(in_array($link->id, [$relationLink1->id, $relationLink2->id]));
            $this->assertNotEmpty(count($link->personDetails));
            foreach ($link->personDetails as $personDetail) {
                $this->assertTrue($personDetail instanceof PersonDetail);
                $this->assertTrue($personDetail->person_id == $person->id);
                $this->assertTrue($personDetail->type == PersonDetailService::TYPE_PORTRAIT);
                $this->assertTrue($personDetail->relation_type == 'link');
                $this->assertTrue($personDetail->relation_id == $link->id);
            }
        }
        try {
            $personFactory->generate(
                $firstName,
                $lastName,
                $fullName,
                new PersonFactoryDTO([
                    'relation' => $relationWord1,
                    'type' => PersonDetailService::TYPE_PORTRAIT
                ]),
            );
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelTypeException);
        }
        $newFirstName = Word::factory()->create();
        $newRelationLink = Link::factory()->create();
        $newRelationWord = Word::factory()->create();
        $samePerson = $personFactory->generate(
            $newFirstName,
            $lastName,
            $fullName,
            new PersonFactoryDTO([
                'relation' => $relationLink1,
                'type' => PersonDetailService::TYPE_PORTRAIT
            ]),
            new PersonFactoryDTO([
                'relation' => $relationWord1,
                'type' => PersonDetailService::TYPE_DESCRIPTION
            ]),
            new PersonFactoryDTO([
                'relation' => $newRelationLink,
                'type' => PersonDetailService::TYPE_PORTRAIT
            ]),
            new PersonFactoryDTO([
                'relation' => $newRelationWord,
                'type' => PersonDetailService::TYPE_DESCRIPTION
            ]),
        );
        $this->assertTrue($samePerson->id == $person->id);
        $this->assertTrue(count($samePerson->links) == 2);
        $this->assertTrue(count($samePerson->words) == 2);
        $this->assertTrue($samePerson->first_name_word_id == $newFirstName->id);
        $this->assertTrue(count($samePerson->personDetails) == 4);
        $personDetails = $samePerson->personDetails;
        foreach ($personDetails as $personDetail) {
            $this->assertTrue(in_array($personDetail->relation_id, [
                $relationLink1->id, $relationWord1->id,
                $newRelationLink->id, $newRelationWord->id
            ]));
        }
        foreach ($samePerson->links as $link) {
            $this->assertTrue(in_array($link->id, [$newRelationLink->id, $relationLink1->id]));
        }
        foreach ($samePerson->words as $word) {
            $this->assertTrue(in_array($word->id, [$newRelationWord->id, $relationWord1->id]));
        }
    }
}
