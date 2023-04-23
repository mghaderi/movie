<?php

namespace App\Domains\Genre\Services\Factories;

use App\Domains\Genre\Models\Genre;

class GenreFactory {

    public function generate(): Genre {
        return new Genre();
    }
}
