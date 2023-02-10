<?php

namespace App\Models\Traits;

use App\Services\PossibleMorphService;

trait HasMorph {

    public function getPossibleMorphNamesAttribute(): array {
        return (new PossibleMorphService())->getPossibleMorphNames(self::class);
    }

    public function getPossibleMorphClassesAttribute(): array {
        return (new PossibleMorphService())->getPossibleMorphClasses(self::class);
    }

    public function getPossibleMorphsAttribute(): array {
        return (new PossibleMorphService())->getPossibleMorphs(self::class);
    }
}
