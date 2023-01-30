<?php

namespace App\Domains\Word\Services\Factories;

use App\Domains\Word\Models\Language;
use App\Domains\Word\Services\LanguageService;
use App\Exceptions\DuplicateModelException;

class LanguageFactory {

    public LanguageService $languageService;

    public function __construct() {
        $this->languageService = new LanguageService();
    }

    public function generate(string $name): Language {
        $this->languageService->setLanguage($this->languageService->fetchOrCreateLanguage());
        $this->languageService->setLanguageName($name);
        try {
            $this->languageService->checkForDuplicateName();
        } catch (DuplicateModelException $exception) {
            return $this->languageService->fetchLanguage($name);
        }
        $this->languageService->saveLanguage();
        return $this->languageService->fetchOrCreateLanguage();
    }
}
