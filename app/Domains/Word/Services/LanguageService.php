<?php

namespace App\Domains\Word\Services;

use App\Domains\Word\Models\Language;
use App\Exceptions\CanNotFindModelException;
use App\Exceptions\CanNotSaveModelException;
use App\Exceptions\DuplicateModelException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LanguageService
{
    private ?Language $language;

    public function setLanguage(Language $language): void {
        $this->language = $language;
    }

    public function saveLanguage() {
        if ($this->language instanceof Language) {
            try {
                $this->language->saveOrFail();
                return;
            } catch (\Exception|\Throwable $exception) {
                throw new CanNotSaveModelException('language model can not be saved. attributes: ' .
                    implode($this->language->getAttributes()));
            }
        }
        throw new CanNotFindModelException('can not find language model');
    }

    public function fetchOrCreateLanguage(): Language {
        if ($this->language instanceof Language) {
            return $this->language;
        }
        return (new Language());
    }

    public function fetchLanguage(string $name): Language {
        $language = Language::where('name', $name)->first();
        if ($language instanceof Language) {
            return $language;
        }
        throw new ModelNotFoundException('can not find language model for name: ' . $name);
    }

    public function setLanguageName(string $name): void {
        $this->language->name = $name;
    }

    public function checkForDuplicateName(): void {
        if ($this->language instanceof Language) {
            $oldLanguage = Language::where('name', $this->language->name)->first();
            if (($oldLanguage instanceof Language) && ($oldLanguage->id === $this->language->id)) {
                throw new DuplicateModelException('duplicate language model, with same name. attributes: : ' .
                    implode($oldLanguage->getAttributes()));
            }
            return;
        }
        throw new ModelNotFoundException('can not find language model');
    }
}
