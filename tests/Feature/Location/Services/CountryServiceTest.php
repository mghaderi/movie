<?php

namespace Tests\Feature\Location\Services;

use App\Domains\Location\Models\Country;
use App\Domains\Location\Services\CountryService;
use App\Domains\Word\Models\Word;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CountryServiceTest extends TestCase {
    use RefreshDatabase;

    /** @test */
    public function set_country_data_test() {
        $countryService = new CountryService();
        $word = Word::factory()->create();
        try {
            $countryService->setCountryData(
                shortName: 'IRI',
                word: $word
            );
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $countryService->country = Country::factory()->create();
        try {
            $countryService->setCountryData(
                shortName: 'IRI',
                word: $word
            );
            $this->assertTrue($countryService->country->word->id == $word->id);
            $this->assertTrue($countryService->country->short_name == 'IRI');
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function set_country_test() {
        $countryService = new CountryService();
        $this->assertTrue($countryService->country == null);
        try {
            $countryService->setCountry(Country::factory()->create());
            $this->assertTrue($countryService->country instanceof Country);
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function save_country_test() {
        $countryService = new CountryService();
        try {
            $countryService->saveCountry();
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $countryService->country = Country::factory()->create();
        try {
            $countryService->saveCountry();
            $this->assertTrue(!empty($countryService->country->id));
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function fetch_or_create_country_test() {
        $countryService = new CountryService();
        $country = $countryService->fetchOrCreateCountry();
        $this->assertEmpty($country->id);
        $countryService->setCountry($country);
        $countryService->saveCountry();
        $country = $countryService->fetchOrCreateCountry();
        $this->assertNotEmpty($country->id);
    }

    /** @test */
    public function fetch_countries_test() {
        $word = Word::factory()->create();
        $country = Country::factory()->create(['word_id' => $word->id, 'short_name' => 'IRI']);
        $countryService = new CountryService();
        $countries = $countryService->fetchCountries(
            shortName: 'IRI',
            word: $word
        );
        $this->assertTrue(count($countries) == 1);
        $countries = $countryService->fetchCountries(
            word: $word
        );
        $this->assertTrue(count($countries) == 1);
        $countries = $countryService->fetchCountries(
            shortName: 'IRI',
        );
        $this->assertTrue(count($countries) == 1);
    }
}
