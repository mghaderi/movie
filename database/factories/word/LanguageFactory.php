<?php

namespace Database\Factories\word;

use App\Domains\Auth\Models\User;
use App\Domains\Word\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LanguageFactory extends Factory {

    protected $model = Language::class;

    public function definition() {
        return [
            'name' => null,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }

}
