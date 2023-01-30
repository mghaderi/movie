<?php

namespace App\Domains\Word\Services\Factories;

use App\Domains\Word\Models\Language;
use App\Domains\Word\Services\LanguageService;

class LanguageFactory {

    public LanguageService $languageService;

    public function __construct() {
        $this->languageService = new LanguageService();
    }

    public function generate(string $name): Language {
        $this->languageService->setLanguage($this->languageService->fetchOrCreateLanguage());
        $this->languageService->setLanguageName($name);
        $this->languageService->checkForDuplicateName();
        $this->languageService->saveLanguage();
        return $this->languageService->fetchOrCreateLanguage();
    }
}
