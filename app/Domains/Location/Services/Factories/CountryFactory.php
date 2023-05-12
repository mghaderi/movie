<?php

namespace App\Domains\Location\Services\Factories;

use App\Domains\Location\Models\Country;
use App\Domains\Location\Services\CountryService;
use App\Domains\Word\Models\Word;
use App\Domains\Word\Services\WordService;
use App\Exceptions\DuplicateModelException;
use Illuminate\Support\Facades\DB;

class CountryFactory {

    public function generate(string $shortName, Word $word): Country {
        DB::beginTransaction();
        $countryService = new CountryService();
        $countiesShorName = $countryService->fetchCountries(shortName: $shortName);
        $countiesWord = $countryService->fetchCountries(word: $word);
        if (
            $countiesWord->first() &&
            ($countiesWord->first()->short_name != $shortName)
        ) {
            throw new DuplicateModelException(
                'country with same word exist with id: ' . $countiesWord->first()->id
            );
        }
        if ($countiesShorName->first()) {
            $countryService->setCountry($countiesShorName->first());
            $oldWord = $countiesShorName->first()->word;
            if (!empty($oldWord) && ($oldWord->id != $word->id)) {
                try {
                    (new WordService())->remove($oldWord, $countiesShorName->first());
                } catch (\Exception $exception) {}
            }
        } else {
            $countryService->setCountry($countryService->fetchOrCreateCountry());
        }
        $countryService->setCountryData($shortName, $word);
        $countryService->saveCountry();
        DB::commit();
        return $countryService->fetchOrCreateCountry();
    }
}
