<?php

namespace Tests\Feature\Person\Services;

use App\Domains\Media\Models\Link;
use App\Domains\Media\Services\LinkService;
use App\Domains\Person\Models\Person;
use App\Domains\Person\Models\PersonDetail;
use App\Domains\Person\Services\PersonDetailService;
use App\Domains\Word\Models\Word;
use App\Domains\Word\Services\WordService;
use App\Exceptions\DuplicateModelException;
use App\Exceptions\InvalidTypeException;
use App\Exceptions\ModelTypeException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonDetailServiceTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function set_person_detail_test() {
        $personDetailService = new PersonDetailService();
        $this->assertEmpty($personDetailService->personDetail);
        $personDetailService->setPersonDetail(PersonDetail::factory()->create());
        $this->assertTrue($personDetailService->personDetail instanceof PersonDetail);
    }

    /** @test */
    public function save_person_detail_test() {
        $personDetailService = new PersonDetailService();
        try {
            $personDetailService->savePersonDetail();
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $personDetailService->personDetail = new PersonDetail();
        try {
            $personDetailService->savePersonDetail();
            $this->assertNotEmpty($personDetailService->personDetail->id);
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function fetch_or_create_person_detail_test() {
        $personDetailService = new PersonDetailService();
        $this->assertEmpty($personDetailService->fetchOrCreatePersonDetail()->id);
        $personDetail = PersonDetail::factory()->create();
        $personDetailService->personDetail = $personDetail;
        $this->assertNotEmpty($personDetailService->fetchOrCreatePersonDetail()->id);
        $this->assertTrue($personDetailService->fetchOrCreatePersonDetail()->id === $personDetail->id);
    }

    /** @test */
    public function person_detail_types_relations_test() {
        $personDetailService = new PersonDetailService();
        $response = $personDetailService->personDetailTypesRelations();
        $this->assertIsArray($response);
        $foundDescription = false;
        $foundPortrait = false;
        foreach ($response as $type => $class) {
            if ($type === PersonDetailService::TYPE_DESCRIPTION) {
                $this->assertTrue($class === Word::class);
                $foundDescription = true;
            } elseif ($type === PersonDetailService::TYPE_PORTRAIT) {
                $this->assertTrue($class === Link::class);
                $foundPortrait = true;
            } else {
                $this->fail();
            }
        }
        if (!$foundPortrait || !$foundDescription) {
            $this->fail();
        }
    }

    /** @test */
    public function set_person_test() {
        $personDetailService = new PersonDetailService();
        try {
            $personDetailService->setPerson(Person::factory()->create());
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $personDetailService->personDetail = PersonDetail::factory()->create();
        try {
            $person = Person::factory()->create();
            $personDetailService->setPerson($person);
            $this->assertTrue($personDetailService->personDetail->person_id === $person->id);
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function set_relation_test() {
        $personDetailService = new PersonDetailService();
        try {
            $personDetailService->setRelation(
                Word::factory()->create(),
                PersonDetailService::TYPE_DESCRIPTION
            );
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $personDetailService->personDetail = PersonDetail::factory()->create();
        $word = Word::factory()->create();
        try {
            $personDetailService->setRelation(
                $word,
                PersonDetailService::TYPE_DESCRIPTION
            );
            $this->assertTrue($personDetailService->personDetail->type === PersonDetailService::TYPE_DESCRIPTION);
            $this->assertTrue($personDetailService->personDetail->relation_type === 'word');
            $this->assertTrue($personDetailService->personDetail->relation_id === $word->id);
        } catch (\Exception $exception) {
            $this->fail();
        }
        $link = Link::factory()->create();
        try {
            $personDetailService->setRelation(
                $link,
                PersonDetailService::TYPE_PORTRAIT
            );
            $this->assertTrue($personDetailService->personDetail->type === PersonDetailService::TYPE_PORTRAIT);
            $this->assertTrue($personDetailService->personDetail->relation_type === 'link');
            $this->assertTrue($personDetailService->personDetail->relation_id === $link->id);
        } catch (\Exception $exception) {
            $this->fail();
        }
        try {
            $personDetailService->setRelation(
                $link,
                PersonDetailService::TYPE_DESCRIPTION
            );
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelTypeException);
        }
        try {
            $personDetailService->setRelation(
                $word,
                PersonDetailService::TYPE_PORTRAIT
            );
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelTypeException);
        }
        try {
            $personDetailService->setRelation(
                $word,
                'wrong type'
            );
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelTypeException);
        }
    }

    /** @test */
    public function check_for_duplicate_test() {
        $personDetailService = new PersonDetailService();
        try {
            $personDetailService->checkForDuplicate();
            $this->fail();
        } catch(\Exception $exception) {
            $this->assertTrue(in_array(get_class($exception), [
                ModelNotFoundException::class,
                InvalidTypeException::class,
            ]));
        }
        $person = Person::factory()->create();
        $link = Link::factory()->create();
        $personDetailService->personDetail = PersonDetail::factory()->create([
            'person_id' => $person->id,
            'relation_type' => 'link',
            'relation_id' => $link->id,
            'type' => PersonDetailService::TYPE_PORTRAIT
        ]);
        try {
            $personDetailService->checkForDuplicate();
        } catch (\Exception $exception) {
            $this->fail();
        }
        $personDetailService->personDetail = new PersonDetail([
            'person_id' => $person->id,
            'relation_type' => 'link',
            'relation_id' => $link->id,
            'type' => PersonDetailService::TYPE_PORTRAIT
        ]);
        try {
            $personDetailService->checkForDuplicate();
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof DuplicateModelException);
        }
        $personDetailService->personDetail->save();
        try {
            $personDetailService->checkForDuplicate();
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof DuplicateModelException);
        }
    }

    /** @test */
    public function fetch_relation_services_test() {
        $personDetailService = new PersonDetailService();
        $response = $personDetailService->fetchRelationSerices();
        $this->assertArrayHasKey(Link::class, $response);
        $this->assertArrayHasKey(Word::class, $response);
        $this->assertTrue($response[Link::class] == LinkService::class);
        $this->assertTrue($response[Word::class] == WordService::class);
        unset($response[Link::class]);
        unset($response[Word::class]);
        $this->assertEmpty($response);
    }

    /** @test */
    public function remove_relation_test() {
        $personDetailService = new PersonDetailService();
        try {
            $personDetailService->removeRelation(new Person(), Link::factory()->create());
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        try {
            $personDetailService->removeRelation(Person::factory()->create(), new Link());
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        try {
            $personDetailService->removeRelation(
                Person::factory()->create(),
                Link::factory()->create()
            );
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $person = Person::factory()->create();
        $link = Link::factory()->create();
        $linkId = $link->id;
        $word = Word::factory()->create();
        $wordId = $word->id;
        $dontRemoveWord = Word::factory()->create();
        $dontRemoveWordId = $dontRemoveWord->id;
        $dontRemoveLink = Link::factory()->create();
        $dontRemoveLinkId = $dontRemoveLink->id;
        $otherPerson = Person::factory()->create();
        $personDetailLinkDontRemove = PersonDetail::factory()->create([
            'person_id' => $otherPerson->id,
            'relation_id' => $dontRemoveLink->id,
            'relation_type' => $dontRemoveLink->morphName,
            'type' => PersonDetailService::TYPE_PORTRAIT
        ]);
        $personDetailLinkDontRemoveId = $personDetailLinkDontRemove->id;
        $personDetailWordDontRemove = PersonDetail::factory()->create([
            'person_id' => $otherPerson->id,
            'relation_id' => $dontRemoveWord->id,
            'relation_type' => $dontRemoveWord->morphName,
            'type' => PersonDetailService::TYPE_DESCRIPTION
        ]);
        $personDetailWordDontRemoveId = $personDetailWordDontRemove->id;
        $personDetailWordDontRemoveWord = PersonDetail::factory()->create([
            'person_id' => $person->id,
            'relation_id' => $dontRemoveWord->id,
            'relation_type' => $dontRemoveWord->morphName,
            'type' => PersonDetailService::TYPE_DESCRIPTION
        ]);
        $personDetailWordDontRemoveWordId = $personDetailWordDontRemoveWord->id;
        $personDetailLinkDontRemoveLink = PersonDetail::factory()->create([
            'person_id' => $person->id,
            'relation_id' => $dontRemoveLink->id,
            'relation_type' => $dontRemoveLink->morphName,
            'type' => PersonDetailService::TYPE_PORTRAIT
        ]);
        $personDetailLinkDontRemoveLinkId = $personDetailLinkDontRemoveLink->id;
        $personDetailLink = PersonDetail::factory()->create([
            'person_id' => $person->id,
            'relation_id' => $link->id,
            'relation_type' => $link->morphName,
            'type' => PersonDetailService::TYPE_PORTRAIT
        ]);
        $personDetailLinkId = $personDetailLink->id;
        $personDetailWord = PersonDetail::factory()->create([
            'person_id' => $person->id,
            'relation_id' => $word->id,
            'relation_type' => $word->morphName,
            'type' => PersonDetailService::TYPE_DESCRIPTION
        ]);
        $personDetailWordId = $personDetailWord->id;
        try {
            $personDetailService->removeRelation($person, $link);
            $personDetailService->removeRelation($person, $word);
            $personDetailService->removeRelation($person, $dontRemoveLink);
            $personDetailService->removeRelation($person, $dontRemoveWord);
        } catch (\Exception $exception) {
            $this->fail();
        }
        $this->assertEmpty(Link::where('id', $linkId)->first());
        $this->assertEmpty(Word::where('id', $wordId)->first());
        $this->assertEmpty(PersonDetail::where('id', $personDetailLinkId)->first());
        $this->assertEmpty(PersonDetail::where('id', $personDetailWordId)->first());
        $this->assertEmpty(PersonDetail::where('id', $personDetailLinkDontRemoveLinkId)->first());
        $this->assertEmpty(PersonDetail::where('id', $personDetailWordDontRemoveWordId)->first());
        $this->assertNotEmpty(Link::where('id', $dontRemoveLinkId)->first());
        $this->assertNotEmpty(Word::where('id', $dontRemoveWordId)->first());
        $this->assertNotEmpty(PersonDetail::where('id', $personDetailWordDontRemoveId)->first());
        $this->assertNotEmpty(PersonDetail::where('id', $personDetailLinkDontRemoveId)->first());
    }
}
