<?php

namespace Tests\Feature\Word\Services;

use App\Domains\Word\Models\Word;
use App\Domains\Word\Services\WordDetailBigService;
use App\Domains\Word\Services\WordDetailSmallService;
use App\Domains\Word\Services\WordService;
use App\Exceptions\InvalidTypeException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WordServiceTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function word_detail_classes_test() {
        $wordService = new WordService();
        $response = $wordService->wordDetailClasses();
        $this->assertIsArray($response);
        foreach ($response as $value) {
            $this->assertIsArray($value);
            $this->assertArrayHasKey('class', $value);
            $this->assertArrayHasKey('service', $value);
        }
    }

    /** @test */
    public function word_detail_service_object_test() {
        $wordService = new WordService();
        try {
            $wordService->wordDetailServiceObject();
            $this->fail();
        } catch(\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $wordService->word = Word::factory()->create();
        try {
            $wordService->wordDetailServiceObject();
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $wordService->word->type = 'wrong type';
        try {
            $wordService->wordDetailServiceObject();
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $wordService->word->type = 'small';
        try {
            $this->assertTrue(
                $wordService->wordDetailServiceObject()
                instanceof
                WordDetailSmallService
            );
        } catch (\Exception $exception) {
            $this->fail();
        }
        $wordService->word->type = 'big';
        try {
            $this->assertTrue(
                $wordService->wordDetailServiceObject()
                    instanceof
                    WordDetailBigService
            );
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function set_word_type_test() {
        $wordService = new WordService();
        try {
            $wordService->setWordType('small');
            $this->fail();
        } catch(\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $wordService->word = Word::factory()->create();
        try {
            $wordService->setWordType('wrong type');
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof InvalidTypeException);
        }
        try {
            $wordService->setWordType('small');
            $this->assertTrue($wordService->word->type === 'small');
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function set_word_test() {
        $wordService = new WordService();
        $this->assertTrue(empty($wordService->word));
        $wordService->setWord(Word::factory()->create());
        $this->assertTrue($wordService->word instanceof Word);
    }

    /** @test */
    public function save_word_test() {
        $wordService = new WordService();
        try {
            $wordService->saveWord();
            $this->fail();
        } catch(\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $wordService->word = new Word();
        try {
            $wordService->saveWord();
            $this->assertTrue(! empty($wordService->word->id));
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function fetch_or_create_word_test() {
        $wordService = new WordService();
        $word = $wordService->fetchOrCreateWord();
        $this->assertTrue(empty($word->id));
        $wordService->word = Word::factory()->create();
        $word = $wordService->fetchOrCreateWord();
        $this->assertTrue(! empty($word->id));
    }
}
