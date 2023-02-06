<?php

namespace Database\Factories\person;

use App\Domains\Person\Models\PersonDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonDetailFactory extends Factory {

    protected $model = PersonDetail::class;

    public function definition() {
        return [
            'person_id' => null,
            'type' => null,
            'relation_type' => null,
            'relation_id' => null,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }

}
