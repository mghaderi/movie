<?php

namespace App\Domains\Genre\Services\Factories;

use App\Domains\Genre\Models\Genre;
use App\Domains\Genre\Services\GenreService;
use App\Domains\Word\Models\Word;
use App\Domains\Word\Services\WordService;
use App\Exceptions\DuplicateModelException;
use Illuminate\Support\Facades\DB;

class GenreFactory {

    public function generate(string $name, Word $word): Genre {
        DB::beginTransaction();
        $genreService = new GenreService();
        $genresName = $genreService->fetchGenres(name: $name);
        $genresWord = $genreService->fetchGenres(word: $word);
        if (
            $genresWord->first() &&
            ($genresWord->first()->name != $name)
        ) {
            throw new DuplicateModelException(
                'country with same word exist with id: ' . $genresWord->first()->id
            );
        }
        if ($genresName->first()) {
            $genreService->setGenre($genresName->first());
            $oldWord = $genresName->first()->word;
            if (!empty($oldWord) && ($oldWord->id != $word->id)) {
                try {
                    (new WordService())->remove($oldWord, $genresName->first());
                } catch (\Exception $exception) {}
            }
        } else {
            $genreService->setGenre($genreService->fetchOrCreateGenre());
        }
        $genreService->setGenreData(name: $name, word: $word);
        $genreService->saveGenre();
        DB::commit();
        return $genreService->fetchOrCreateGenre();
    }
}
