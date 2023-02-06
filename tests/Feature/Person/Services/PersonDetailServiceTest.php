<?php

namespace Tests\Feature\Person\Services;

use App\Domains\Media\Models\Link;
use App\Domains\Person\Models\PersonDetail;
use App\Domains\Person\Services\PersonDetailService;
use App\Domains\Word\Models\Word;
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
    public function person_details_types_relations_test() {
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
    /** @todo */

}
