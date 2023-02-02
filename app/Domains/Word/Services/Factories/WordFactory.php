<?php

namespace App\Domains\Word\Services\Factories;

use App\Domains\Word\Exceptions\Factories\CanNotGenerateWordException;
use App\Domains\Word\Models\Word;
use App\Domains\Word\Services\Factories\DTOs\WordFactoryDTO;
use App\Domains\Word\Services\WordService;
use Illuminate\Support\Facades\DB;

class WordFactory {

    public WordService $wordService;

    public function __construct() {
        $this->wordService = new WordService();
    }

    public function generate(string $type, WordFactoryDTO ...$wordFactoryDTOs): Word {
        if (! empty($wordFactoryDTOs)) {
            DB::beginTransaction();
            $this->wordService->setWord($this->wordService->fetchOrCreateWord());
            $this->wordService->setWordType($type);
            $this->wordService->saveWord();
            foreach ($wordFactoryDTOs as $wordFactoryDTO) {
                $wordDetailService = $this->wordService->wordDetailServiceObject();
                $wordDetailService->setWordDetail($wordDetailService->fetchOrCreateWordDetail());
                $wordDetailService->setData(
                    $wordFactoryDTO->language,
                    $wordFactoryDTO->value,
                    $this->wordService->fetchOrCreateWord()
                );
                $wordDetailService->saveWordDetail();
            }
            DB::commit();
            return $this->wordService->fetchOrCreateWord();
        }
        throw new CanNotGenerateWordException('error in generating word');
    }
}
