<?php

namespace App\Models\Traits;

use App\Services\PossibleMorphService;
use Illuminate\Support\Collection;

trait IsMorph {
    public function getMorphNameAttribute(): string {
        $possibleMorphService = new PossibleMorphService();
        return $possibleMorphService->getAllMorphs()[self::class];
    }

    public function getMorphLinkClassesAttribute(): string {
        $possibleMorphService = new PossibleMorphService();
        return $possibleMorphService->getAllMorphLinks()[self::class];
    }

    public function getMorphLinksAttribute(): Collection
    {
        $result = collect([]);
        $possibleMorphService = new PossibleMorphService();
        foreach ($possibleMorphService->getAllMorphLinks()[self::class] as $morphLink) {
            $response = $morphLink::where('relation_id', $this->id)
                ->where('relation_type', $this->morphName)
                ->get();
            foreach ($response as $res) {
                $result[] = $res;
            }
        }
        return $result;
    }
}
