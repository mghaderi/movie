<?php

namespace App\Domains\Word\Services\Factories;

use App\Domains\Word\Exceptions\Factories\CanNotGenerateWordDetailException;
use App\Domains\Word\Models\Language;
use App\Domains\Word\Models\WordDetailSmall;
use App\Domains\Word\Services\Interfaces\WordDetailServiceInterface;
use App\Domains\Word\Services\WordService;
use Illuminate\Support\Facades\DB;

class WordFactory {

    public WordService $wordService;

    public function __construct(WordService $wordService) {
        $this->wordService = $wordService;
    }

    public function generate(WordDetailServiceInterface ...$wordDetailServices): WordService {
        /** @todo */
//        DB::beginTransaction();
//        $model = $this->wordService->fetchOrCreateModel();
//        $model->type = $language->id;
//        $model->value = $value;
//        if ($model->save()) {
//            $this->wordDetailService->setModel($model);
//            DB::commit();
//            return $this->wordDetailService;
//        }
//        throw new CanNotGenerateWordDetailException('error in generating word: ', implode($model->getAttributes()));
    }
}
