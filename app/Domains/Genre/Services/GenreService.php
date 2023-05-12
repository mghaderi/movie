<?php

namespace App\Domains\Genre\Services;

use App\Domains\Genre\Models\Genre;
use App\Domains\Word\Models\Word;
use App\Exceptions\CanNotSaveModelException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;

class GenreService {

    public ?Genre $genre = null;

    public function fetchOrCreateGenre(): Genre {
        if ($this->genre instanceof Genre) {
            return $this->genre;
        }
        return (new Genre());
    }

    public function setGenre(Genre $genre): void {
        $this->genre = $genre;
    }

    public function saveGenre(): void {
        if ($this->genre instanceof Genre) {
            try {
                $this->genre->saveOrFail();
                return;
            } catch (\Exception | \Throwable $exception) {
                throw new CanNotSaveModelException('genre model can not be saved. attributes: ' .
                implode(',', $this->genre->getAttributes()));
            }
        }
        throw new ModelNotFoundException('can not find genre model');
    }

    public function setGenreData(
        ?string $name = null,
        ?Word $word = null
    ): void {
        if ($this->genre instanceof Genre) {
            $this->genre->word_id = !empty($word) ? $word->id : null;
            $this->genre->name = !empty($name) ? $name : null;
            return;
        }
        throw new ModelNotFoundException('can not find genre model');
    }

    public function fetchGenres(
        ?string $name = null,
        ?Word $word = null
    ): Collection {
        return Genre::filter($name, $word->id ?? null)->get();
    }

}
