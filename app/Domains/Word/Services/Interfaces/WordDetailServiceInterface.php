<?php

namespace App\Domains\Word\Services\Interfaces;

use App\Domains\Word\Models\Interfaces\WordDetailInterface;
use App\Domains\Word\Models\Language;
use App\Domains\Word\Models\Word;
use Illuminate\Database\Eloquent\Collection;

interface WordDetailServiceInterface {
    public function fetchOrCreateWordDetail(): WordDetailInterface;
    public function setWordDetail(WordDetailInterface $wordDetail): void;
    public function setData(Language $language, string $value, Word $word): void;
    public function saveWordDetail(): void;
    public function fetchWordDetails(
        ?Language $language = null, ?string $value = null, ?Word $word = null
    ): Collection;
}
