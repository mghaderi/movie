<?php

namespace Tests\Feature\Word\Services\Factories;

use App\Domains\Word\Models\Language;
use App\Domains\Word\Services\Factories\LanguageFactory;
use App\Exceptions\DuplicateModelException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LanguageFactoryTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function generate_test() {
        $languageFactory = new LanguageFactory();
        try {
            $language = $languageFactory->generate('english');
        } catch(\Exception $exception) {
            $this->fail();
        }
        $this->assertTrue($language instanceof Language);
        try {
            $languageDuplicate = $languageFactory->generate('english');
        } catch (\Exception $exception) {
            $this->fail();
        }
        $this->assertTrue($languageDuplicate instanceof Language);
        $this->assertTrue($language->id === $languageDuplicate->id);
        try {
            $languageTwo = $languageFactory->generate('persian');
        } catch (\Exception $exception) {
            $this->fail();
        }
        $this->assertTrue($language instanceof Language);
        $this->assertTrue($languageTwo->id !== $language->id);
    }
}
