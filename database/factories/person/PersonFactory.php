<?php

namespace Database\Factories\person;

use App\Domains\Person\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory {

    protected $model = Person::class;

    public function definition() {
        return [
            'first_name_word_id' => null,
            'last_name_word_id' => null,
            'full_name_word_id' => null,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }

}
