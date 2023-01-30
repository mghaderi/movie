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

class WordDetailSmallService implements WordDetailServiceInterface
{
    private ?WordDetailSmall $wordDetailSmall;

    public function fetchOrCreateWordDetail(): WordDetailInterface {
        if (! empty($this->wordDetailSmall)) {
            return $this->wordDetailSmall;
        }
        return (new WordDetailSmall());
    }

    public function setDetailWord(WordDetailInterface $wordDetail): void {
        if ($wordDetail instanceof WordDetailSmall) {
            $this->wordDetailSmall = $wordDetail;
        }
        throw new ModelTypeException('expected ' . WordDetailSmall::class . ', found: ' . get_class($wordDetail));
    }

    public function setLanguage(Language $language): void {
        if ($this->wordDetailSmall instanceof WordDetailSmall) {
            $this->wordDetailSmall->language_id = $language->id;
            return;
        }
        throw new CanNotFindModelException('can not find word detail small model');
    }

    public function setValue(string $value): void {
        if ($this->wordDetailSmall instanceof WordDetailSmall) {
            $this->wordDetailSmall->value = $value;
            return;
        }
        throw new CanNotFindModelException('can not find word detail small model');
    }

    public function setWord(Word $word): void {
        if ($this->wordDetailSmall instanceof WordDetailSmall) {
            $this->wordDetailSmall->word_id = $word->id;
            return;
        }
        throw new CanNotFindModelException('can not find word detail small model');
    }

    public function saveWordDetail(): void {
        if ($this->wordDetailSmall instanceof WordDetailSmall) {
            try {
                $this->wordDetailSmall->saveOrFail();
                return;
            } catch (\Exception|\Throwable $exception) {
                throw new CanNotSaveModelException('word detail small model can not be saved. attributes: ' .
                    implode($this->wordDetailSmall->getAttributes()));
            }
        }
        throw new CanNotFindModelException('can not find word detail small model');
    }

}