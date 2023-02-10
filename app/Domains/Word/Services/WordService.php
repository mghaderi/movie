<?php

namespace App\Domains\Word\Services;

use App\Domains\Word\Models\Word;
use App\Domains\Word\Models\WordDetailBig;
use App\Domains\Word\Models\WordDetailSmall;
use App\Domains\Word\Services\Interfaces\WordDetailServiceInterface;
use App\Exceptions\CanNotDeleteModelException;
use App\Exceptions\CanNotSaveModelException;
use App\Exceptions\InvalidTypeException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class WordService {

    public ?Word $word = null;

    public const WORD_TYPE_BIG = 'big';
    public const WORD_TYPE_SMALL = 'small';

    /** @test */
    public function wordTypes(): array {
        return [
            self::WORD_TYPE_SMALL => self::WORD_TYPE_SMALL,
            self::WORD_TYPE_BIG => self::WORD_TYPE_BIG,
        ];
    }

    public function wordDetailClasses(): array {
        return [
            self::WORD_TYPE_SMALL => [
                'class' => WordDetailSmall::class,
                'service' => WordDetailSmallService::class,
            ],
            self::WORD_TYPE_BIG => [
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
                throw new CanNotSaveModelException('word model can not be saved. attributes: ' . implode(',', $this->word->getAttributes()));
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

    public function remove(Word $word): void {
        if (! empty($word->id)) {
            DB::beginTransaction();
            foreach ($word->wordDetailSmalls as $small) {
                if (! $small->delete()) {
                    throw new CanNotDeleteModelException(
                        'can not delete word detail small model with id: ' . $small->id
                    );
                }
            }
            foreach ($word->wordDetailBigs as $big) {
                if (! $big->delete()) {
                    throw new CanNotDeleteModelException(
                        'can not delete word detail big model with id: ' . $big->id
                    );
                }
            }
            if (! $word->delete()) {
                throw new CanNotDeleteModelException(
                    'can not delete word model with id: ' . $word->id
                );
            }
            DB::commit();
            return;
        }
        throw new ModelNotFoundException('model word not found');
    }
}
