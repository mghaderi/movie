<?php

namespace App\Models\Interfaces;

use App\Services\PossibleMorphService;

interface MorphInterface {

    function setPossibleMorphClasses(PossibleMorphService $possibleMorphService): PossibleMorphService;

}
