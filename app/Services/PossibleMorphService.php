<?php

namespace App\Services;

use App\Domains\Media\Models\Link;
use App\Domains\Media\Models\MediaDetailRelation;
use App\Domains\Person\Models\PersonDetail;
use App\Domains\Word\Models\Language;
use App\Domains\Word\Models\Word;

class PossibleMorphService {

    private $allMorphs = [
        Language::class => 'language',
        Word::class => 'word',
        Link::class => 'link',
    ];

    private $allMorphLinks = [
        Link::class => [
            PersonDetail::class,
            MediaDetailRelation::class,
        ],
        Word::class => [
            PersonDetail::class,
            MediaDetailRelation::class,
        ],
        Language::class => [
            MediaDetailRelation::class,
        ],
    ];

    public function getAllMorphNames(): array {
        return array_values($this->allMorphs);
    }

    public function getAllMorphClasses(): array {
        return array_keys($this->allMorphs);
    }

    public function getAllMorphs(): array {
        return $this->allMorphs;
    }

    public function getAllMorphLinks(): array {
        return $this->allMorphLinks;
    }

    public function getPossibleMorphNames(string $class): array {
        return array_values($this->getPossibleMorphs($class));
    }

    public function getPossibleMorphClasses(string $class): array {
        return array_keys($this->getPossibleMorphs($class));
    }

    public function getPossibleMorphs(string $class): array {
        $isMorphClasses = [];
        foreach ($this->allMorphLinks as $isMorphClass => $hasMorphClasses) {
            foreach ($hasMorphClasses as $hasMorphClass) {
                if (($class == $hasMorphClass) && (! in_array($isMorphClass, $isMorphClasses))) {
                    $isMorphClasses[] = $isMorphClass;
                }
            }
        }
        $result = [];
        foreach ($isMorphClasses as $isMorphClass) {
            if (! empty($this->allMorphs[$isMorphClass])) {
                $result[$isMorphClass] = $this->allMorphs[$isMorphClass];
            }
        }
        return $result;
    }
}
