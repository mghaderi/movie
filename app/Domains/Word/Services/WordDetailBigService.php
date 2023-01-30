<?php

namespace App\Domains\Word\Services;

use App\Domains\Word\Models\Interfaces\WordDetailInterface;
use App\Domains\Word\Models\Language;
use App\Domains\Word\Models\Word;
use App\Domains\Word\Models\WordDetailBig;
use App\Domains\Word\Models\WordDetailSmall;
use App\Domains\Word\Services\Interfaces\WordDetailServiceInterface;
use App\Exceptions\CanNotFindModelException;
use App\Exceptions\CanNotSaveModelException;
use App\Exceptions\ModelTypeException;

class WordDetailBigService implements WordDetailServiceInterface
{
    private ?WordDetailBig $wordDetailBig;

    public function fetchOrCreateWordDetail(): WordDetailInterface {
        if (! empty($this->wordDetailBig)) {
            return $this->wordDetailBig;
        }
        return (new WordDetailBig());
    }

    public function setDetailWord(WordDetailInterface $wordDetail): void {
        if ($wordDetail instanceof WordDetailBig) {
            $this->wordDetailBig = $wordDetail;
        }
        throw new ModelTypeException('expected ' . WordDetailBig::class . ', found: ' . get_class($wordDetail));
    }

    public function setLanguage(Language $language): void {
        if ($this->wordDetailBig instanceof WordDetailBig) {
            $this->wordDetailBig->language_id = $language->id;
            return;
        }
        throw new CanNotFindModelException('can not find word detail big model');
    }

    public function setValue(string $value): void {
        if ($this->wordDetailBig instanceof WordDetailBig) {
            $this->wordDetailBig->value = $value;
            return;
        }
        throw new CanNotFindModelException('can not find word detail big model');
    }

    public function setWord(Word $word): void {
        if ($this->wordDetailBig instanceof WordDetailBig) {
            $this->wordDetailBig->word_id = $word->id;
            return;
        }
        throw new CanNotFindModelException('can not find word detail big model');
    }

    public function saveWordDetail(): void {
        if ($this->wordDetailBig instanceof WordDetailBig) {
            try {
                $this->wordDetailBig->saveOrFail();
                return;
            } catch (\Exception|\Throwable $exception) {
                throw new CanNotSaveModelException('word detail big model can not be saved. attributes: ' .
                    implode($this->wordDetailBig->getAttributes()));
            }
        }
        throw new CanNotFindModelException('can not find word detail big model');
    }
}
