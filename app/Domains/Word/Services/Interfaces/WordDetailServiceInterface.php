<?php

namespace App\Domains\Word\Services\Interfaces;

use App\Domains\Word\Models\Interfaces\WordDetailInterface;

interface WordDetailServiceInterface {
    public function fetchOrCreateModel(): WordDetailInterface;
    public function setModel(WordDetailInterface $wordDetail): void;
}
