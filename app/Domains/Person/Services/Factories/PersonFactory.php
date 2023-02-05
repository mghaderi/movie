<?php

namespace App\Domains\Person\Services\Factories;

use App\Domains\Person\Exceptions\Factories\CanNotGeneratePersonException;
use App\Domains\Person\Models\Person;
use App\Domains\Person\Services\Factories\DTOs\PersonFactoryDTO;
use App\Domains\Person\Services\PersonDetailService;
use App\Domains\Person\Services\PersonService;
use App\Domains\Word\Models\Word;
use Illuminate\Support\Facades\DB;

class PersonFactory
{
    public function generate(Word $firstName, Word $lastName, Word $fullName, PersonFactoryDTO ...$personFactoryDTOs): Person {
        if (! empty($personFactoryDTOs)) {
            DB::beginTransaction();
            $personService = new PersonService();
            $personService->setPerson($personService->fetchOrCreatePerson());
            $personService->setFirstNameWord($firstName);
            $personService->setLastNameWord($lastName);
            $personService->setFullNameWord($fullName);
            $personService->savePerson();
            foreach ($personFactoryDTOs as $personFactoryDTO) {
                $personDetailService = new PersonDetailService();
                $personDetailService->setPersonDetail($personDetailService->fetchOrCreatePersonDetail());
                $personDetailService->setRelation($personFactoryDTO->relation, $personFactoryDTO->type);
                $personDetailService->setPerson($personService->fetchOrCreatePerson());
                $personDetailService->savePersonDetail();
            }
            DB::commit();
        }
        throw new CanNotGeneratePersonException('error in generating person');
    }
}
