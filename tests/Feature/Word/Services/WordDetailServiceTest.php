<?php

namespace Tests\Feature\Word\Services;

use App\Domains\Word\Models\WordDetailBig;
use App\Domains\Word\Models\WordDetailSmall;
use App\Domains\Word\Services\WordDetailBigService;
use App\Domains\Word\Services\WordDetailSmallService;
use App\Exceptions\ModelTypeException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WordDetailServiceTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function set_detail_word_small_test() {
        $wordDetailSmall = WordDetailSmall::factory()->create();
        $wordDetailBig = WordDetailBig::factory()->create();
        $wordDetailSmallService = new WordDetailSmallService();
        $this->assertTrue($wordDetailSmallService->wordDetailSmall === null);
        try {
            $wordDetailSmallService->setWordDetail($wordDetailBig);
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelTypeException);
        }
        try {
            $wordDetailSmallService->setWordDetail($wordDetailSmall);
            $this->assertTrue($wordDetailSmallService->wordDetailSmall instanceof WordDetailSmall);
        } catch(\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function set_detail_word_big_test() {
        $wordDetailBig = WordDetailBig::factory()->create();
        $wordDetailSmall = WordDetailSmall::factory()->create();
        $wordDetailBigService = new WordDetailBigService();
        $this->assertTrue($wordDetailBigService->wordDetailBig === null);
        try {
            $wordDetailBigService->setWordDetail($wordDetailSmall);
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelTypeException);
        }
        try {
            $wordDetailBigService->setWordDetail($wordDetailBig);
            $this->assertTrue($wordDetailBigService->wordDetailBig instanceof WordDetailBig);
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function fetch_or_create_word_detail_small_test() {
        $wordDetailSmallService = new WordDetailSmallService();
        $this->assertTrue($wordDetailSmallService->fetchOrCreateWordDetail()->id === null);
        $wordDetailSmall = WordDetailSmall::factory()->create();
        $wordDetailSmallService->setWordDetail($wordDetailSmall);
        $this->assertTrue($wordDetailSmallService->fetchOrCreateWordDetail()->id === $wordDetailSmall->id);
    }

    /** @test */
    public function fetch_or_create_word_detail_big_test() {
        $wordDetailBigService = new WordDetailBigService();
        $this->assertTrue($wordDetailBigService->fetchOrCreateWordDetail()->id === null);
        $wordDetailBig = WordDetailBig::factory()->create();
        $wordDetailBigService->setWordDetail($wordDetailBig);
        $this->assertTrue($wordDetailBigService->fetchOrCreateWordDetail()->id === $wordDetailBig->id);
    }
}
