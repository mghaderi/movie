<?php

namespace Tests\Feature\Word\Services;

use App\Domains\Word\Models\Language;
use App\Domains\Word\Models\Word;
use App\Domains\Word\Models\WordDetailBig;
use App\Domains\Word\Models\WordDetailSmall;
use App\Domains\Word\Services\WordDetailBigService;
use App\Domains\Word\Services\WordDetailSmallService;
use App\Exceptions\ModelTypeException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    /** @test */
    public function set_data_small_test() {
        $wordDetailSmallService = new WordDetailSmallService();
        try {
            $wordDetailSmallService->setData(
                Language::factory()->create(['name' => 'persian']),
                'جنایی',
                Word::factory()->create(['type' => 'small'])
            );
            $this->fail();
        } catch(\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        try {
            $wordDetailSmallService->setWordDetail(new WordDetailSmall());
            $language = Language::factory()->create(['name' => 'persian']);
            $word = Word::factory()->create(['type' => 'small']);
            $wordDetailSmallService->setData(
                $language,
                'جنایی',
                $word
            );
            $this->assertTrue($wordDetailSmallService->wordDetailSmall->value === 'جنایی');
            $this->assertTrue($wordDetailSmallService->wordDetailSmall->language_id === $language->id);
            $this->assertTrue($wordDetailSmallService->wordDetailSmall->word_id === $word->id);
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function set_data_big_test() {
        $wordDetailBigService = new WordDetailBigService();
        try {
            $wordDetailBigService->setData(
                Language::factory()->create(['name' => 'persian']),
                'جنایی',
                Word::factory()->create(['type' => 'big'])
            );
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        try {
            $wordDetailBigService->setWordDetail(new WordDetailBig());
            $language = Language::factory()->create(['name' => 'persian']);
            $word = Word::factory()->create(['type' => 'big']);
            $wordDetailBigService->setData(
                $language,
                'جنایی',
                $word
            );
            $this->assertTrue($wordDetailBigService->wordDetailBig->value === 'جنایی');
            $this->assertTrue($wordDetailBigService->wordDetailBig->language_id === $language->id);
            $this->assertTrue($wordDetailBigService->wordDetailBig->word_id === $word->id);
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

}
