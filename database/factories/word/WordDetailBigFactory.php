<?php

namespace Database\Factories\word;

use App\Domains\Word\Models\WordDetailBig;
use Illuminate\Database\Eloquent\Factories\Factory;

class WordDetailBigFactory extends Factory {

    protected $model = WordDetailBig::class;

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
