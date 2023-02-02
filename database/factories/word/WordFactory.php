<?php

namespace Database\Factories\word;

use App\Domains\Word\Models\Word;
use Illuminate\Database\Eloquent\Factories\Factory;

class WordFactory extends Factory {

    protected $model = Word::class;

    public function definition() {
        return [
            'type' => null,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
