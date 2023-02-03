<?php

namespace Tests\Feature\Word\Services\Factories;

use App\Domains\Word\Models\Language;
use App\Domains\Word\Models\Word;
use App\Domains\Word\Models\WordDetailBig;
use App\Domains\Word\Models\WordDetailSmall;
use App\Domains\Word\Services\Factories\DTOs\WordFactoryDTO;
use App\Domains\Word\Services\Factories\WordFactory;
use App\Domains\Word\Services\WordService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WordFactoryTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function generate_small_word_test() {
        $wordFactory = new WordFactory();
        $english = Language::factory()->create(['name' => 'english']);
        $persian = Language::factory()->create(['name' => 'persian']);
        try {
            $word = $wordFactory->generate(
                WordService::WORD_TYPE_SMALL,
                new WordFactoryDTO(['language' => $english, 'value' => 'hello']),
                new WordFactoryDTO(['language' => $persian, 'value' => 'سلام']),
            );
        } catch(\Exception $exception) {
            $this->fail();
        }
        $this->assertTrue($word instanceof Word);
        $this->assertTrue(! empty($word->id));
        $this->assertTrue($word->type === WordService::WORD_TYPE_SMALL);
        $this->assertTrue(count($word->wordDetailSmalls) === 2);
        $this->assertTrue($word->wordDetailSmalls[0] instanceof WordDetailSmall);
        $this->assertTrue($word->wordDetailSmalls[1] instanceof WordDetailSmall);
        $this->assertTrue(! empty($word->wordDetailSmalls[0]->id));
        $this->assertTrue(! empty($word->wordDetailSmalls[1]->id));
        if ($word->wordDetailSmalls[0]->language->id == $english->id) {
            $this->assertTrue($word->wordDetailSmalls[0]->value === 'hello');
        } elseif ($word->wordDetailSmalls[0]->language->id == $persian->id) {
            $this->assertTrue($word->wordDetailSmalls[0]->value === 'سلام');
        } else {
            $this->fail();
        }
        if ($word->wordDetailSmalls[1]->language->id == $english->id) {
            $this->assertTrue($word->wordDetailSmalls[1]->value === 'hello');
        } elseif ($word->wordDetailSmalls[1]->language->id == $persian->id) {
            $this->assertTrue($word->wordDetailSmalls[1]->value === 'سلام');
        } else {
            $this->fail();
        }
    }

    /** @test */
    public function generate_big_word_test() {
        $wordFactory = new WordFactory();
        $english = Language::factory()->create(['name' => 'english']);
        $persian = Language::factory()->create(['name' => 'persian']);
        try {
            $word = $wordFactory->generate(
                WordService::WORD_TYPE_BIG,
                new WordFactoryDTO(['language' => $english, 'value' => 'hello']),
                new WordFactoryDTO(['language' => $persian, 'value' => 'سلام']),
            );
        } catch (\Exception $exception) {
            $this->fail();
        }
        $this->assertTrue($word instanceof Word);
        $this->assertTrue(! empty($word->id));
        $this->assertTrue($word->type === WordService::WORD_TYPE_BIG);
        $this->assertTrue(count($word->wordDetailBigs) === 2);
        $this->assertTrue($word->wordDetailBigs[0] instanceof WordDetailBig);
        $this->assertTrue($word->wordDetailBigs[1] instanceof WordDetailBig);
        $this->assertTrue(! empty($word->wordDetailBigs[0]->id));
        $this->assertTrue(! empty($word->wordDetailBigs[1]->id));
        if ($word->wordDetailBigs[0]->language->id == $english->id) {
            $this->assertTrue($word->wordDetailBigs[0]->value === 'hello');
        } elseif ($word->wordDetailBigs[0]->language->id == $persian->id) {
            $this->assertTrue($word->wordDetailBigs[0]->value === 'سلام');
        } else {
            $this->fail();
        }
        if ($word->wordDetailBigs[1]->language->id == $english->id) {
            $this->assertTrue($word->wordDetailBigs[1]->value === 'hello');
        } elseif ($word->wordDetailBigs[1]->language->id == $persian->id) {
            $this->assertTrue($word->wordDetailBigs[1]->value === 'سلام');
        } else {
            $this->fail();
        }
    }
}
