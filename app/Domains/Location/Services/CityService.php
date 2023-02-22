<?php

namespace App\Domains\Location\Services;

use App\Domains\Location\Models\City;
use App\Domains\Location\Models\Country;
use App\Domains\Word\Models\Word;
use App\Exceptions\CanNotSaveModelException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CityService {

    public ?City $city = null;

    public function setCityData(
        ?string $shortName = null,
        ?Word $word = null,
        ?Country $country = null
    ): void {
        if ($this->city instanceof City) {
            $this->city->word_id = !empty($word) ? $word->id : null;
            $this->city->short_name = !empty($shortName) ? $shortName : null;
            $this->city->country_id = !empty($country) ? $country->id : null;
            return;
        }
        throw new ModelNotFoundException('can not find city model');
    }

    public function setCity(City $city): void {
        $this->city = $city;
    }

    public function saveCity(): void {
        if ($this->city instanceof City) {
            try {
                $this->city->saveOrFail();
                return;
            } catch (\Exception | \Throwable $exception) {
                throw new CanNotSaveModelException('city model can not be saved. attributes: ' .
                    implode(',', $this->city->getAttributes()));
            }
        }
        throw new ModelNotFoundException('can not find city model');
    }

    public function fetchOrCreateCity(): City {
        if ($this->city instanceof City) {
            return $this->city;
        }
        return (new City());
    }
}
