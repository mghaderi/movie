<?php

namespace Tests\Feature\Media\Services;

use App\Domains\Media\Models\MediaDetail;
use App\Domains\Media\Models\MediaDetailDatum;
use App\Domains\Media\Services\MediaDetailDatumService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MediaDetailDatumServiceTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function set_media_detail_datum_test() {
        $mediaDetailDatumService = new MediaDetailDatumService();
        $this->assertTrue($mediaDetailDatumService->mediaDetailDatum == null);
        $mediaDetailDatumService->setMediaDetailDatum(MediaDetailDatum::factory()->create());
        $this->assertTrue($mediaDetailDatumService->mediaDetailDatum instanceof MediaDetailDatum);
    }

    /** @test */
    public function save_media_detail_datum_test() {
        $mediaDetailDatumService = new MediaDetailDatumService();
        try {
            $mediaDetailDatumService->saveMediaDetailDatum();
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $mediaDetailDatumService->mediaDetailDatum = MediaDetailDatum::factory()->create();
        try {
            $mediaDetailDatumService->saveMediaDetailDatum();
            $this->assertNotEmpty($mediaDetailDatumService->mediaDetailDatum->id);
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function fetch_or_create_media_detail_datum_test() {
        $mediaDetailDatumService = new MediaDetailDatumService();
        $mediaDetailDatum = $mediaDetailDatumService->fetchOrCreateMediaDetailDatum();
        $this->assertEmpty($mediaDetailDatum->id);
        $mediaDetailDatumService->mediaDetailDatum = MediaDetailDatum::factory()->create();
        $mediaDetailDatum = $mediaDetailDatumService->fetchOrCreateMediaDetailDatum();
        $this->assertNotEmpty($mediaDetailDatum->id);
    }
    /** @test */
    public function set_media_detail_test () {
        $mediaDetailDatumService = new MediaDetailDatumService();
        $mediaDetail = MediaDetail::factory()->create();
        try {
            $mediaDetailDatumService->setMediaDetail($mediaDetail);
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $mediaDetailDatumService->mediaDetailDatum = MediaDetailDatum::factory()->create();
        try {
            $mediaDetailDatumService->setMediaDetail(new MediaDetail());
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        try {
            $mediaDetailDatumService->setMediaDetail($mediaDetail);
            $this->assertTrue(
                $mediaDetailDatumService->mediaDetailDatum->media_detail_id ==
                $mediaDetail->id
            );
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function set_data_test() {
        $mediaDetailDatumService = new MediaDetailDatumService();
        try {
            $mediaDetailDatumService->setData('test_name', 'test_value');
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $mediaDetailDatumService->mediaDetailDatum = MediaDetailDatum::factory()->create();
        try {
            $mediaDetailDatumService->setData('test_name', 'test_value');
            $this->assertTrue($mediaDetailDatumService->mediaDetailDatum->name == 'test_name');
            $this->assertTrue($mediaDetailDatumService->mediaDetailDatum->value == 'test_value');
        } catch (\Exception $exception) {
            $this->fail();
        }
    }
}
