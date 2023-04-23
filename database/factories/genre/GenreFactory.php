<?php

namespace Database\Factories\genre;

use App\Domains\Genre\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenreFactory extends Factory {

    protected $model = Genre::class;

    public function definition() {
        return [
            'word_id' => null,
            'name' => null,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
