<?php

namespace App\Domains\Word\Services\Interfaces;

use App\Domains\Word\Models\Interfaces\WordDetailInterface;
use App\Domains\Word\Models\Language;
use App\Domains\Word\Models\Word;

interface WordDetailServiceInterface {
    public function fetchOrCreateWordDetail(): WordDetailInterface;
    public function setWordDetail(WordDetailInterface $wordDetail): void;
    public function setLanguage(Language $language): void;
    public function setValue(string $value): void;
    public function setWord(Word $word): void;
    public function saveWordDetail(): void;
}
