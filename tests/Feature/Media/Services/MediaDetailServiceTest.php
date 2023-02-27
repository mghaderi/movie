<?php

namespace Tests\Feature\Media\Services;

use App\Domains\Media\Models\Media;
use App\Domains\Media\Models\MediaDetail;
use App\Domains\Media\Services\MediaDetailService;
use App\Domains\Media\Services\MediaService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MediaDetailServiceTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function set_media_detail_data_test() {
        $mediaDetailService = new MediaDetailService();
        try {
            $mediaDetailService->setMediaDetailData('genre');
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $mediaDetailService->mediaDetail = MediaDetail::factory()->create();
        try {
            $mediaDetailService->setMediaDetailData('genre');
            $this->assertTrue($mediaDetailService->mediaDetail->type === 'genre');
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function set_media_detail_test() {
        $mediaDetailService = new MediaDetailService();
        $this->assertTrue($mediaDetailService->mediaDetail === null);
        try {
            $mediaDetailService->setMediaDetail(MediaDetail::factory()->create());
            $this->assertTrue($mediaDetailService->mediaDetail instanceof MediaDetail);
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function save_media_detail_test() {
        $mediaDetailService = new MediaDetailService();
        try {
            $mediaDetailService->saveMediaDetail();
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $mediaDetailService->mediaDetail = new MediaDetail();
        try {
            $mediaDetailService->saveMediaDetail();
            $this->assertTrue(! empty($mediaDetailService->mediaDetail->id));
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function fetch_or_create_media_detail_test() {
        $mediaDetailService = new MediaDetailService();
        $mediaDetail = $mediaDetailService->fetchOrCreateMediaDetail();
        $this->assertEmpty($mediaDetail->id);
        $mediaDetailService->setMediaDetail($mediaDetail);
        $mediaDetailService->saveMediaDetail();
        $mediaDetail = $mediaDetailService->fetchOrCreateMediaDetail();
        $this->assertNotEmpty($mediaDetail->id);
    }

    /** @test */
    public function set_media_test() {
        $mediaDetailService = new MediaDetailService();
        try {
            $mediaDetailService->setMedia(Media::factory()->create());
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $mediaDetailService->mediaDetail = MediaDetail::factory()->create();
        try {
            $mediaDetailService->setMedia(new Media());
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $media = Media::factory()->create();
        try {
            $mediaDetailService->setMedia($media);
            $this->assertTrue($mediaDetailService->mediaDetail->media_id == $media->id);
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

}
