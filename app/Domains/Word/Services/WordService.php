<?php

namespace App\Domains\Word\Services;

use App\Domains\Word\Models\Word;

class WordService
{
    public Word|null $word;

    public function __construct(Word|null $word = null) {
        $this->word = $word;
    }

    public function wordTypes(): array {
        return [
            'small',
            'big'
        ];
    }

    public function fetchOrCreateModel(): Word
    {
        if ($this->word instanceof Word::class) {
            return $this->word;
        }
        return (new Word());
    }
}
