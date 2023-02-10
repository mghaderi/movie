<?php

namespace App\Models\Traits;

use App\Services\PossibleMorphService;

trait IsMorph {
    public function getMorphNameAttribute(): string {
        $possibleMorphService = new PossibleMorphService();
        return $possibleMorphService->getAllMorphs()[self::class];
    }

    public function getMorphLinksAttribute(): string {
        $possibleMorphService = new PossibleMorphService();
        return $possibleMorphService->getAllMorphLinks()[self::class];
    }
}
