<?php

namespace App\Services;

use App\Domains\Media\Models\Link;
use App\Domains\Word\Models\Language;
use App\Domains\Word\Models\Word;

class PossibleMorphService {

    private $allMorphs = [
        Language::class => 'language',
        Word::class => 'word',
        Link::class => 'link',
    ];
    private $possibleMorphs = [];

    public function getAllMorphNames(): array {
        return array_values($this->allMorphs);
    }

    public function getAllMorphClasses(): array {
        return array_keys($this->allMorphs);
    }

    public function getAllMorphs(): array {
        return $this->allMorphs;
    }

    public function setPossibleMorphs(...$morphClasses): void {
        foreach ($morphClasses as $morphClass) {
            $this->possibleMorphs[$morphClass] = $this->allMorphs[$morphClass];
        }
    }

    public function getPossibleMorphNames(): array {
        return array_values($this->possibleMorphs);
    }

    public function getPossibleMorphClasses(): array {
        return array_keys($this->possibleMorphs);
    }

    public function getPossibleMorphs(): array {
        return $this->possibleMorphs;
    }
}
