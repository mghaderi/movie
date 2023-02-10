<?php

namespace App\Domains\Person\Services\Factories;

use App\Domains\Person\Models\Person;
use App\Domains\Person\Services\Factories\DTOs\PersonFactoryDTO;
use App\Domains\Person\Services\PersonDetailService;
use App\Domains\Person\Services\PersonService;
use App\Domains\Word\Models\Word;
use App\Exceptions\DuplicateModelException;
use Illuminate\Support\Facades\DB;

class PersonFactory {

    public function generate(Word $firstName, Word $lastName, Word $fullName, PersonFactoryDTO ...$personFactoryDTOs): Person {
        DB::beginTransaction();
        $personService = new PersonService();
        $personService->setPerson($personService->fetchOrCreatePerson());
        $personService->setFullNameWord($fullName);
        try {
            $personService->checkForDuplicateFullNameWord();
        } catch (DuplicateModelException $exception) {
            $personService->setPerson($personService->fetchPersonWithFullNameWord($fullName));
        }
        $personService->setFirstNameWord($firstName);
        $personService->setLastNameWord($lastName);
        $personService->savePerson();
        if (! empty($personFactoryDTOs)) {
            foreach ($personFactoryDTOs as $personFactoryDTO) {
                $personDetailService = new PersonDetailService();
                $personDetailService->setPersonDetail($personDetailService->fetchOrCreatePersonDetail());
                $personDetailService->setRelation($personFactoryDTO->relation, $personFactoryDTO->type);
                $personDetailService->setPerson($personService->fetchOrCreatePerson());
                try {
                    $personDetailService->checkForDuplicate();
                    $personDetailService->savePersonDetail();
                } catch (DuplicateModelException $exception) {}
            }
            $personDetailService = new PersonDetailService();
            foreach ($personService->fetchRelations() as $relation) {
                $toBeRemoved = true;
                foreach ($personFactoryDTOs as $personFactoryDTO) {
                    if ($relation->id == $personFactoryDTO->relation->id) {
                        $toBeRemoved = false;
                    }
                }
                if ($toBeRemoved) {
                    $personDetailService->removeRelation(
                        $personService->fetchOrCreatePerson(),
                        $relation
                    );
                }
            }
        } else {
            $personDetailService = new PersonDetailService();
            foreach ($personService->fetchRelations() as $relation) {
                $personDetailService->removeRelation(
                    $personService->fetchOrCreatePerson(),
                    $relation
                );
            }
        }
        DB::commit();
        return $personService->fetchPersonWithFullNameWord($fullName);
    }
}
