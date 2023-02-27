<?php

namespace Tests\Feature\Media\Services;

use App\Domains\Media\Models\MediaDetail;
use App\Domains\Media\Models\MediaDetailRelation;
use App\Domains\Media\Services\MediaDetailRelationService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MediaDetailRelationServiceTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function set_media_detail_relation_test() {
        $mediaDetailRelationService = new MediaDetailRelationService();
        $this->assertTrue($mediaDetailRelationService->mediaDetailRelation === null);
        try {
            $mediaDetailRelationService->setMediaDetailRelation(MediaDetailRelation::factory()->create());
            $this->assertTrue($mediaDetailRelationService->mediaDetailRelation instanceof MediaDetailRelation);
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function set_media_detail_test() {
        $mediaDetailRelationService = new MediaDetailRelationService();
        try {
            $mediaDetailRelationService->setMediaDetail(MediaDetail::factory()->create());
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $mediaDetailRelationService->mediaDetailRelation = new MediaDetailRelation();
        $mediaDetail = new MediaDetail();
        try {
            $mediaDetailRelationService->setMediaDetail($mediaDetail);
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $mediaDetail = MediaDetail::factory()->create();
        try {
            $mediaDetailRelationService->setMediaDetail($mediaDetail);
            $this->assertTrue($mediaDetailRelationService->mediaDetailRelation->media_detail_id == $mediaDetail->id);
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function fetch_or_create_media_detail_relation_test() {
        $mediaDetailRelationService = new MediaDetailRelationService();
        $mediaDetailRelation = $mediaDetailRelationService->fetchOrCreateMediaDetailRelation();
        $this->assertEmpty($mediaDetailRelation->id);
        $mediaDetailRelationService->mediaDetailRelation = MediaDetailRelation::factory()->create();
        $mediaDetailRelation = $mediaDetailRelationService->fetchOrCreateMediaDetailRelation();
        $this->assertNotEmpty($mediaDetailRelation->id);
    }

    /** @test */
    public function set_relation_test() {
        $mediaDetailRelationService = new MediaDetailRelationService();
        $mediaDetailRelation = MediaDetailRelation::factory()->create();
        $possibleMorphObject = $mediaDetailRelation->possibleMorphClasses[0]::factory()->create();
        try {
            $mediaDetailRelationService->setRelation($possibleMorphObject);
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $mediaDetailRelationService->mediaDetailRelation = $mediaDetailRelation;
        foreach ($mediaDetailRelation->possibleMorphClasses as $possibleMorphClass) {
            $possibleMorphObject = $possibleMorphClass::factory()->create();
            try {
                $mediaDetailRelationService->setRelation($possibleMorphObject);
                $this->assertTrue($mediaDetailRelationService->mediaDetailRelation->relation_type == $possibleMorphObject->morphName);
                $this->assertTrue($mediaDetailRelationService->mediaDetailRelation->relation_id == $possibleMorphObject->id);
            } catch (\Exception $exception) {
                $this->fail();
            }
        }
    }

    /** @test */
    public function save_media_detail_relation_test() {
        $mediaDetailRelationService = new MediaDetailRelationService();
        try {
            $mediaDetailRelationService->saveMediaDetailRelation();
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $mediaDetailRelationService->mediaDetailRelation = new MediaDetailRelation();
        try {
            $mediaDetailRelationService->saveMediaDetailRelation();
            $this->assertNotEmpty($mediaDetailRelationService->mediaDetailRelation->id);
        } catch (\Exception $exception) {
            $this->fail();
        }
    }
}
