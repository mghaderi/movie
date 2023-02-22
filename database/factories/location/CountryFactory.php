<?php

namespace Database\Factories\location;

use App\Domains\Location\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory {

    protected $model = Country::class;

    public function definition() {
        return [
            'word_id' => null,
            'short_name' => null,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
