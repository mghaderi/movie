<?php

namespace Tests\Feature\Person\Services;

use App\Domains\Media\Models\Link;
use App\Domains\Person\Models\Person;
use App\Domains\Person\Models\PersonDetail;
use App\Domains\Person\Services\PersonDetailService;
use App\Domains\Word\Models\Word;
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

}
