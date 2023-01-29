<?php

namespace App\Domains\Word\Services;

use App\Domains\Word\Models\Interfaces\WordDetailInterface;
use App\Domains\Word\Models\WordDetailBig;
use App\Domains\Word\Services\Interfaces\WordDetailServiceInterface;
use App\Exceptions\ModelTypeException;

class WordDetailBigService implements WordDetailServiceInterface
{
    public WordDetailBig|null $wordDetailBig;

    public function __construct(WordDetailBig|null $wordDetailBig = null) {
        $this->wordDetailBig = $wordDetailBig;
    }

    public function fetchOrCreateModel(): WordDetailInterface
    {
        if (! empty($this->wordDetailBig)) {
            return $this->wordDetailBig;
        }
        return (new WordDetailBig());
    }

    public function setModel(WordDetailInterface $wordDetail): void
    {
        if ($wordDetail instanceof WordDetailBig) {
            $this->wordDetailBig = $wordDetail;
        }
        throw new ModelTypeException('expected ' . WordDetailBig::class . ', found: ' . get_class($wordDetail));
    }
}
