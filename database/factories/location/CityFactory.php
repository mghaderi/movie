<?php

namespace Database\Factories\location;

use App\Domains\Location\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory {

    protected $model = City::class;

    public function definition() {
        return [
            'word_id' => null,
            'country_id' => null,
            'short_name' => null,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
