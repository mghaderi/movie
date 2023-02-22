<?php

namespace Tests\Feature\Location\Services;

use App\Domains\Location\Models\City;
use App\Domains\Location\Models\Country;
use App\Domains\Location\Services\CityService;
use App\Domains\Word\Models\Word;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CityServiceTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function set_city_data_test() {
        $cityService = new CityService();
        $word = Word::factory()->create();
        $country  = Country::factory()->create();
        try {
            $cityService->setCityData(
                shortName: 'IRI',
                word: $word,
                country: $country
            );
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $cityService->city = City::factory()->create();
        try {
            $cityService->setCityData(
                shortName: 'IRI',
                word: $word,
                country: $country
            );
            $this->assertTrue($cityService->city->word->id == $word->id);
            $this->assertTrue($cityService->city->short_name == 'IRI');
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function set_city_test() {
        $cityService = new CityService();
        $this->assertTrue($cityService->city == null);
        try {
            $cityService->setCity(City::factory()->create());
            $this->assertTrue($cityService->city instanceof City);
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function save_city_test() {
        $cityService = new CityService();
        try {
            $cityService->saveCity();
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $cityService->city = City::factory()->create();
        try {
            $cityService->saveCity();
            $this->assertTrue(!empty($cityService->city->id));
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function fetch_or_create_city() {
        $cityService = new CityService();
        $city = $cityService->fetchOrCreateCity();
        $this->assertEmpty($city->id);
        $cityService->setCity($city);
        $cityService->saveCity();
        $city = $cityService->fetchOrCreateCity();
        $this->assertNotEmpty($city->id);
    }
}
