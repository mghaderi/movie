<?php

namespace App\Domains\Word\Services;

use App\Domains\Word\Models\Interfaces\WordDetailInterface;
use App\Domains\Word\Models\Word;
use App\Domains\Word\Models\WordDetailBig;
use App\Domains\Word\Models\WordDetailSmall;
use App\Domains\Word\Services\Interfaces\WordDetailServiceInterface;
use App\Exceptions\CanNotFindModelException;
use App\Exceptions\CanNotSaveModelException;
use App\Exceptions\InvalidTypeException;

class WordService
{
    private ?Word $word;

    private function wordDetailClasses(): array {
        return [
            'small' => [
                'class' => WordDetailSmall::class,
                'service' => WordDetailSmallService::class,
            ],
            'big' => [
                'class' => WordDetailBig::class,
                'service' => WordDetailBigService::class,
            ]
        ];
    }

    public function wordDetailClassName(string $type): string {
        $className = $this->wordDetailClasses()[$type]['class'] ?? '';
        if (empty($className)) {
            throw new InvalidTypeException('word type: ' . $type . ' is invalid');
        }
        return $className;
    }

    public function wordDetailServiceObject(): WordDetailServiceInterface {
        if ($this->word instanceof Word) {
            $className = $this->wordDetailClasses()[$this->word->type]['service'] ?? '';
            if (empty($className)) {
                throw new CanNotFindModelException('can not find word service model for type: ' . $this->word->type);
            }
            return new $className();
        }
        throw new CanNotFindModelException('can not find word model');
    }

    public function setWordType(string $type) {
        if ($this->word instanceof Word) {
            foreach (array_keys($this->wordDetailClasses()) as $wordType) {
                if ($type === $wordType) {
                    $this->word->type = $wordType;
                    return;
                }
            }
            throw new InvalidTypeException('word type: ' . $type . ' is invalid');
        }
        throw new CanNotFindModelException('can not find word model');
    }

    public function setWord(Word $word): void {
        $this->word = $word;
    }

    public function saveWord() {
        if ($this->word instanceof Word) {
            try {
                $this->word->saveOrFail();
                return;
            } catch (\Exception|\Throwable $exception) {
                throw new CanNotSaveModelException('word model can not be saved. attributes: ' . implode($this->word->getAttributes()));
            }
        }
        throw new CanNotFindModelException('can not find word model');
    }

    public function fetchOrCreateWord(): Word {
        if ($this->word instanceof Word::class) {
            return $this->word;
        }
        return (new Word());
    }
}
