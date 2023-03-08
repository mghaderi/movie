<?php

namespace Tests\Feature\Media\Services;

use App\Domains\Media\Models\MediaDetail;
use App\Domains\Media\Models\MediaDetailDatum;
use App\Domains\Media\Models\MediaDetailRelation;
use App\Domains\Media\Models\MediaDetailRelationDatum;
use App\Domains\Media\Services\MediaDetailRelationDatumService;
use App\Domains\Media\Services\MediaDetailRelationService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MediaDetailRelationDatumServiceTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function set_media_detail_relation_datum_test() {
        $mediaDetailRelationDatumService = new MediaDetailRelationDatumService();
        $this->assertTrue(
            $mediaDetailRelationDatumService->mediaDetailRelationDatum === null
        );
        try {
            $mediaDetailRelationDatumService->setMediaDetailRelationDatum(
                MediaDetailRelationDatum::factory()->create()
            );
            $this->assertTrue(
                $mediaDetailRelationDatumService->mediaDetailRelationDatum
                instanceof
                MediaDetailRelationDatum
            );
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function save_media_detail_relation_datum_test() {
        $mediaDetailRelationDatumService = new MediaDetailRelationDatumService();
        try {
            $mediaDetailRelationDatumService->saveMediaDetailRelationDatum();
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $mediaDetailRelationDatumService->mediaDetailRelationDatum = new MediaDetailRelationDatum();
        try {
            $mediaDetailRelationDatumService->saveMediaDetailRelationDatum();
            $this->assertNotEmpty($mediaDetailRelationDatumService->mediaDetailRelationDatum->id);
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function fetch_or_create_media_detail_relation_datum_test() {
        $mediaDetailRelationDatumService = new MediaDetailRelationDatumService();
        $mediaDetailRelationDatum = $mediaDetailRelationDatumService->fetchOrCreateMediaDetailRelationDatum();
        $this->assertEmpty($mediaDetailRelationDatum->id);
        $mediaDetailRelationDatumService->mediaDetailRelationDatum = MediaDetailRelationDatum::factory()->create();
        $mediaDetailRelationDatm = $mediaDetailRelationDatumService->fetchOrCreateMediaDetailRelationDatum();
        $this->assertNotEmpty($mediaDetailRelationDatm->id);
    }

    /** @test */
    public function set_media_detail_relation_test() {
        $mediaDetailRelationDatumService = new MediaDetailRelationDatumService();
        try {
            $mediaDetailRelationDatumService->setMediaDetailRelation(
                MediaDetailRelation::factory()->create()
            );
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $mediaDetailRelationDatumService
            ->mediaDetailRelationDatum = MediaDetailRelationDatum::factory()->create();
        try {
            $mediaDetailRelationDatumService->setMediaDetailRelation(
                new MediaDetailRelation()
            );
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $mediaDetailRelation = MediaDetailRelation::factory()->create();
        try {
            $mediaDetailRelationDatumService->setMediaDetailRelation(
                $mediaDetailRelation
            );
            $this->assertTrue(
                $mediaDetailRelationDatumService
                    ->mediaDetailRelationDatum
                    ->media_detail_relation_id == $mediaDetailRelation->id
            );
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function set_media_detail_datum_test() {
        $mediaDetailRelationDatumService = new MediaDetailRelationDatumService();
        try {
            $mediaDetailRelationDatumService->setMediaDetailDatum(
                MediaDetailDatum::factory()->create()
            );
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $mediaDetailRelationDatumService
            ->mediaDetailRelationDatum = MediaDetailRelationDatum::factory()->create();
        try {
            $mediaDetailRelationDatumService->setMediaDetailDatum(
                new MediaDetailDatum()
            );
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $mediaDetailDatum = MediaDetailDatum::factory()->create();
        try {
            $mediaDetailRelationDatumService->setMediaDetailDatum(
                $mediaDetailDatum
            );
            $this->assertTrue(
                $mediaDetailRelationDatumService
                    ->mediaDetailRelationDatum
                    ->media_detail_datum_id == $mediaDetailDatum->id
            );
        } catch (\Exception $exception) {
            $this->fail();
        }
    }
}
