<?php

namespace Tests\Feature\Word\Services;

use App\Domains\Word\Models\Language;
use App\Domains\Word\Services\LanguageService;
use App\Exceptions\DuplicateModelException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LanguageServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function set_language_test() {
        $language = Language::factory()->create();
        $languageService = new LanguageService();
        $this->assertTrue($languageService->language === null);
        $languageService->setLanguage($language);
        $this->assertTrue($languageService->language instanceof Language);
    }

    /** @test */
    public function save_language_test() {
        $languageService = new LanguageService();
        try {
            $languageService->saveLanguage();
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $languageService->setLanguage(Language::factory()->create(['name' => 'test']));
        try {
            $languageService->saveLanguage();
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function fetch_or_create_language_test() {
        $languageService = new LanguageService();
        $this->assertTrue($languageService->fetchOrCreateLanguage()->id === null);
        $language = Language::factory()->create();
        $languageService->setLanguage($language);
        $this->assertTrue($languageService->fetchOrCreateLanguage()->id === $language->id);

    }

    /** @test  */
    public function fetch_language_test() {
        $languageService = new LanguageService();
        try {
            $languageService->fetchLanguage('test');
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        Language::factory()->create(['name' => 'test']);
        try {
            $languageService->fetchLanguage('test');
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function set_language_name() {
        $language = Language::factory()->create();
        $languageService = new LanguageService();
        try {
            $languageService->setLanguageName('test');
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $languageService->setLanguage($language);
        $languageService->setLanguageName('test');
        $this->assertTrue($languageService->fetchOrCreateLanguage()->name === 'test');
    }

    /** @test */
    public function check_for_duplicate_name_test() {
        $languageService = new LanguageService();
        try {
            $languageService->checkForDuplicateName();
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $language = Language::factory()->create(['name' => 'duplicate test']);
        $languageService->setLanguage($language);
        try {
            $languageService->checkForDuplicateName();
        } catch (\Exception $exception) {
            $this->fail();
        }
        $duplicateLanguage = Language::factory()->create(['name' => 'duplicate test']);
        try {
            $languageService->checkForDuplicateName();
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof DuplicateModelException);
        }
        $duplicateLanguage->delete();
        $duplicateLanguage = new Language(['name' => 'duplicate test']);
        $languageService->setLanguage($duplicateLanguage);
        try {
            $languageService->checkForDuplicateName();
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof DuplicateModelException);
        }
    }
}
