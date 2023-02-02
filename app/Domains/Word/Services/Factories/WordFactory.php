<?php

namespace App\Domains\Word\Services\Factories;

use App\Domains\Word\Exceptions\Factories\CanNotGenerateWordException;
use App\Domains\Word\Models\Word;
use App\Domains\Word\Services\Factories\DTOs\WordFactoryDTO;
use App\Domains\Word\Services\WordService;
use Illuminate\Support\Facades\DB;

class WordFactory {

    public function generate(string $type, WordFactoryDTO ...$wordFactoryDTOs): Word {
        $wordService = new WordService();
        if (! empty($wordFactoryDTOs)) {
            DB::beginTransaction();
            $wordService->setWord($wordService->fetchOrCreateWord());
            $wordService->setWordType($type);
            $wordService->saveWord();
            foreach ($wordFactoryDTOs as $wordFactoryDTO) {
                $wordDetailService = $wordService->wordDetailServiceObject();
                $wordDetailService->setWordDetail($wordDetailService->fetchOrCreateWordDetail());
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
