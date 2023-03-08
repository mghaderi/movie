<?php

namespace Tests\Feature\Media\Services;

use App\Domains\Media\Models\Media;
use App\Domains\Media\Services\MediaService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MediaServiceTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function set_media_data_test() {
        $mediaService = new MediaService();
        try {
            $mediaService->setMediaData('tt1234', 'movies');
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $mediaService->media = Media::factory()->create();
        try {
            $mediaService->setMediaData('tt1234', 'movies');
            $this->assertTrue($mediaService->media->tt_name === 'tt1234');
            $this->assertTrue($mediaService->media->type === 'movies');
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function set_media_test() {
        $mediaService = new MediaService();
        $this->assertTrue($mediaService->media === null);
        try {
            $mediaService->setMedia(Media::factory()->create());
            $this->assertTrue($mediaService->media instanceof Media);
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function save_media_test() {
        $mediaService = new MediaService();
        try {
            $mediaService->saveMedia();
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $mediaService->media = new Media();
        try {
            $mediaService->saveMedia();
            $this->assertTrue(! empty($mediaService->media->id));
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function fetch_or_create_media_test() {
        $mediaService = new MediaService();
        $media = $mediaService->fetchOrCreateMedia();
        $this->assertEmpty($media->id);
        $mediaService->setMedia($media);
        $mediaService->saveMedia();
        $media = $mediaService->fetchOrCreateMedia();
        $this->assertNotEmpty($media->id);
    }

    /** @test */
    public function fetch_medias_test() {
        Media::factory()->create([
            'tt_name' => 'test_tt_name',
            'type' => 'test_type',
            'status' => 'test_status'
        ]);
        $mediaService = new MediaService();
        $medias = $mediaService->fetchMedias(
            ttName: 'test_tt_name',
            type: 'test_type',
            status: 'test_status',
        );
        $this->assertTrue(count($medias) == 1);
        $medias = $mediaService->fetchMedias(
            ttName: 'test_tt_name'
        );
        $this->assertTrue(count($medias) == 1);
        $medias = $mediaService->fetchMedias(
            type: 'test_type'
        );
        $this->assertTrue(count($medias) == 1);
        $medias = $mediaService->fetchMedias(
            status: 'test_status'
        );
        $this->assertTrue(count($medias) == 1);
    }

}
