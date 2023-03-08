<?php

namespace Tests\Feature\Location\Services\Factories;

use App\Domains\Location\Services\Factories\CountryFactory;
use App\Domains\Word\Models\Word;
use App\Exceptions\DuplicateModelException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CountryFactoryTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function generate_test() {
        $countryFactory = new CountryFactory();
        $word1 = Word::factory()->create();
        $word1Id = $word1->id;
        $word2 = Word::factory()->create();
        try {
            $country = $countryFactory->generate('IRI', $word1);
            $this->assertNotEmpty($country->id);
            $this->assertTrue($country->word_id == $word1->id);
            $this->assertTrue($country->short_name == 'IRI');
        } catch (\Exception $exception) {
            $this->fail();
        }
        try {
            $country = $countryFactory->generate('IRI', $word2);
            $this->assertNotEmpty($country->id);
            $this->assertTrue($country->word_id == $word2->id);
            $this->assertTrue($country->short_name == 'IRI');
            $oldWord = Word::where('id', $word1Id)->first();
            $this->assertEmpty($oldWord);
        } catch (\Exception $exception) {
            $this->fail();
        }
        try {
            $country = $countryFactory->generate('IRI', $word2);
            $this->assertNotEmpty($country->id);
            $this->assertTrue($country->word_id == $word2->id);
            $this->assertTrue($country->short_name == 'IRI');
        } catch (\Exception $exception) {
            $this->fail();
        }
        try {
            $country = $countryFactory->generate('FR', $word2);
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof DuplicateModelException);
        }
    }
}
