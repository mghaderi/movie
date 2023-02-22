<?php

namespace App\Domains\Location\Services;

use App\Domains\Location\Models\Country;
use App\Domains\Word\Models\Word;
use App\Exceptions\CanNotSaveModelException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CountryService {

    public ?Country $country = null;

    public function setCountryData(
        ?string $shortName = null,
        ?Word $word = null
    ): void {
        if ($this->country instanceof Country) {
            $this->country->word_id = !empty($word) ? $word->id : null;
            $this->country->short_name = !empty($shortName) ? $shortName : null;
            return;
        }
        throw new ModelNotFoundException('can not find country model');
    }

    public function setCountry(Country $country): void {
        $this->country = $country;
    }

    public function saveCountry(): void {
        if ($this->country instanceof Country) {
            try {
                $this->country->saveOrFail();
                return;
            } catch (\Exception | \Throwable $exception) {
                throw new CanNotSaveModelException('country model can not be saved. attributes: ' .
                    implode(',', $this->country->getAttributes()));
            }
        }
        throw new ModelNotFoundException('can not find Country model');
    }

    public function fetchOrCreateCountry(): Country {
        if ($this->country instanceof Country) {
            return $this->country;
        }
        return (new Country());
    }
}
