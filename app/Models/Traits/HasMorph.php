<?php

namespace App\Models\Traits;

use App\Services\PossibleMorphService;

trait HasMorph {

    public function getPossibleMorphNamesAttribute(): array {
        $possibleMorphService = $this->setPossibleMorphClasses(new PossibleMorphService());
        return $possibleMorphService->getPossibleMorphNames();
    }

    public function getPossibleMorphClassesAttribute(): array {
        $possibleMorphService = $this->setPossibleMorphClasses(new PossibleMorphService());
        return $possibleMorphService->getPossibleMorphClasses();
    }

    public function getPossibleMorphsAttribute(): array {
        $possibleMorphService = $this->setPossibleMorphClasses(new PossibleMorphService());
        return $possibleMorphService->getPossibleMorphs();
    }
}
