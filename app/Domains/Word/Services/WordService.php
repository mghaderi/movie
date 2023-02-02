<?php

namespace App\Domains\Word\Services;

use App\Domains\Word\Models\Word;
use App\Domains\Word\Models\WordDetailBig;
use App\Domains\Word\Models\WordDetailSmall;
use App\Domains\Word\Services\Interfaces\WordDetailServiceInterface;
use App\Exceptions\CanNotSaveModelException;
use App\Exceptions\InvalidTypeException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WordService {

    public ?Word $word = null;

    public function wordDetailClasses(): array {
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

    public function wordDetailServiceObject(): WordDetailServiceInterface {
        if ($this->word instanceof Word) {
            $className = $this->wordDetailClasses()[$this->word->type]['service'] ?? '';
            if (empty($className)) {
                throw new ModelNotFoundException('can not find word service model for type: ' . $this->word->type);
            }
            return (new $className());
        }
        throw new ModelNotFoundException('can not find word model');
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
        throw new ModelNotFoundException('can not find word model');
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
        throw new ModelNotFoundException('can not find word model');
    }

    public function fetchOrCreateWord(): Word {
        if ($this->word instanceof Word) {
            return $this->word;
        }
        return (new Word());
    }
}
