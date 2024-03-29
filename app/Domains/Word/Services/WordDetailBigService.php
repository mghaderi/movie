<?php

namespace App\Domains\Word\Services;

use App\Domains\Word\Models\Interfaces\WordDetailInterface;
use App\Domains\Word\Models\Language;
use App\Domains\Word\Models\Word;
use App\Domains\Word\Models\WordDetailBig;
use App\Domains\Word\Services\Interfaces\WordDetailServiceInterface;
use App\Exceptions\CanNotSaveModelException;
use App\Exceptions\ModelTypeException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class WordDetailBigService implements WordDetailServiceInterface {

    public ?WordDetailBig $wordDetailBig = null;

    public function fetchOrCreateWordDetail(): WordDetailInterface {
        if (! empty($this->wordDetailBig)) {
            return $this->wordDetailBig;
        }
        return (new WordDetailBig());
    }

    public function setWordDetail(WordDetailInterface $wordDetail): void {
        if ($wordDetail instanceof WordDetailBig) {
            $this->wordDetailBig = $wordDetail;
            return;
        }
        throw new ModelTypeException('expected ' . WordDetailBig::class . ', found: ' . get_class($wordDetail));
    }

    public function setData(Language $language, string $value, Word $word): void {
        if ($this->wordDetailBig instanceof WordDetailBig) {
            $this->wordDetailBig->language_id = $language->id;
            $this->wordDetailBig->value = $value;
            $this->wordDetailBig->word_id = $word->id;
            return;
        }
        throw new ModelNotFoundException('can not find word detail big model');
    }

    public function saveWordDetail(): void {
        if ($this->wordDetailBig instanceof WordDetailBig) {
            try {
                $this->wordDetailBig->saveOrFail();
                return;
            } catch (\Exception|\Throwable $exception) {
                throw new CanNotSaveModelException('word detail big model can not be saved. attributes: ' .
                    implode(',', $this->wordDetailBig->getAttributes()));
            }
        }
        throw new ModelNotFoundException('can not find word detail big model');
    }

    public function fetchWordDetails(
        ?Language $language = null,
        ?string $value = null,
        ?Word $word = null
    ): Collection {
        if ($language && $word && $value) {
            return WordDetailBig::where('language_id', $language->id)
                ->where('word_id', $word->id)
                ->where('value', $value)
                ->get();
        }
        if ($language && $word) {
            return WordDetailBig::where('language_id', $language->id)
                ->where('word_id', $word->id)
                ->get();
        }
        if ($language && $value) {
            return WordDetailBig::where('language_id', $language->id)
                ->where('value', $value)
                ->get();
        }
        if ($word && $value) {
            return WordDetailBig::where('word_id', $word->id)
                ->where('value', $value)
                ->get();
        }
        if ($language) {
            return WordDetailBig::where('language_id', $language->id)->get();
        }
        if ($value) {
            return WordDetailBig::where('value', $value)->get();
        }
        if ($word) {
            return WordDetailBig::where('word_id', $word->id)->get();
        }
        return WordDetailBig::all();
    }
}
