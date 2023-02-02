<?php

namespace App\Domains\Word\Services\Factories;

use App\Domains\Word\Models\Language;
use App\Domains\Word\Services\LanguageService;
use App\Exceptions\DuplicateModelException;

class LanguageFactory {
    
    public function generate(string $name): Language {
        $languageService = new LanguageService();
        $languageService->setLanguage($languageService->fetchOrCreateLanguage());
        $languageService->setLanguageName($name);
        try {
            $languageService->checkForDuplicateName();
        } catch (DuplicateModelException $exception) {
            return $languageService->fetchLanguage($name);
        }
        $languageService->saveLanguage();
        return $languageService->fetchOrCreateLanguage();
    }
}
