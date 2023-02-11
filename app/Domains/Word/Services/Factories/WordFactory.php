<?php

namespace App\Domains\Word\Services\Factories;

use App\Domains\Word\Exceptions\Factories\CanNotGenerateWordException;
use App\Domains\Word\Models\Word;
use App\Domains\Word\Services\Factories\DTOs\WordFactoryDTO;
use App\Domains\Word\Services\WordService;
use App\Exceptions\DuplicateModelException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class WordFactory {

    public function generate(string $type, WordFactoryDTO ...$wordFactoryDTOs): Word {
        $wordService = new WordService();
        if (! empty($wordFactoryDTOs)) {
            DB::beginTransaction();
            $wordService->setWord($wordService->fetchOrCreateWord());
            $wordService->setWordType($type);
            foreach ($wordFactoryDTOs as $wordFactoryDTO) {
                $wordDetailService = $wordService->wordDetailServiceObject();
                    $wordDetails = $wordDetailService->fetchWordDetails(
                        language: $wordFactoryDTO->language,
                        value: $wordFactoryDTO->value
                    );
                if ($wordDetails->first()) {
                    $wordService->setWord($wordDetails->first()->word);
                    break;
                }
            }
            $wordService->saveWord();
            foreach ($wordFactoryDTOs as $wordFactoryDTO) {
                $wordDetailService = $wordService->wordDetailServiceObject();
                $wordDetails = $wordDetailService->fetchWordDetails(
                    language: $wordFactoryDTO->language,
                    value: $wordFactoryDTO->value,
                    word: $wordService->fetchOrCreateWord()
                );
                if ($wordDetails->first()) {
                    $wordDetailService->setWordDetail($wordDetails->first());
                } else {
                    $wordDetailService->setWordDetail($wordDetailService->fetchOrCreateWordDetail());
                }
                $wordDetailService->setData(
                    $wordFactoryDTO->language,
                    $wordFactoryDTO->value,
                    $wordService->fetchOrCreateWord()
                );
                $wordDetailService->saveWordDetail();
            }
            DB::commit();
            return $wordService->fetchOrCreateWord();
        }
        throw new CanNotGenerateWordException('error in generating word');
    }
}
