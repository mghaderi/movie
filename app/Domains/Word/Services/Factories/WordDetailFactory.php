<?php

namespace App\Domains\Word\Services\Factories;

use App\Domains\Word\Exceptions\Factories\CanNotGenerateWordDetailException;
use App\Domains\Word\Models\Language;
use App\Domains\Word\Services\Interfaces\WordDetailServiceInterface;
use Illuminate\Support\Facades\DB;

class WordDetailFactory {

    public WordDetailServiceInterface $wordDetailService;

    public function __construct(WordDetailServiceInterface $wordDetailService) {
        $this->wordDetailService = $wordDetailService;
    }

    public function generate(Language $language, string $value): WordDetailServiceInterface {
        DB::beginTransaction();
        $model = $this->wordDetailService->fetchOrCreateModel();
        $model->language_id = $language->id;
        $model->value = $value;
        if ($model->save()) {
            $this->wordDetailService->setModel($model);
            DB::commit();
            return $this->wordDetailService;
        }
        throw new CanNotGenerateWordDetailException('error in generating word: ', implode($model->getAttributes()));
    }
}
