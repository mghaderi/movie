<?php

namespace Database\Factories\word;

use App\Domains\Word\Models\WordDetailSmall;
use Illuminate\Database\Eloquent\Factories\Factory;

class WordDetailSmallFactory extends Factory {

    protected $model = WordDetailSmall::class;

    public function definition() {
        return [
            'word_id' => null,
            'language_id' => null,
            'value' => null,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
