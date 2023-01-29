<?php

namespace App\Domains\Word\Services;

use App\Domains\Word\Models\Interfaces\WordDetailInterface;
use App\Domains\Word\Models\WordDetailSmall;
use App\Domains\Word\Services\Interfaces\WordDetailServiceInterface;
use App\Exceptions\ModelTypeException;

class WordDetailSmallService implements WordDetailServiceInterface
{
    public WordDetailSmall|null $wordDetailSmall;

    public function __construct(WordDetailSmall|null $wordDetailSmall = null) {
        $this->wordDetailSmall = $wordDetailSmall;
    }

    public function fetchOrCreateModel(): WordDetailInterface
    {
        if (! empty($this->wordDetailSmall)) {
            return $this->wordDetailSmall;
        }
        return (new WordDetailSmall());
    }

    public function setModel(WordDetailInterface $wordDetail): void
    {
        if ($wordDetail instanceof WordDetailSmall) {
            $this->wordDetailSmall = $wordDetail;
        }
        throw new ModelTypeException('expected ' . WordDetailSmall::class . ', found: ' . get_class($wordDetail));
    }

}
