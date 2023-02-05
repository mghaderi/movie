<?php

namespace Database\Factories\media;

use App\Domains\Media\Models\Link;
use Illuminate\Database\Eloquent\Factories\Factory;

class LinkFactory extends Factory {

    protected $model = Link::class;

    public function definition() {
        return [
            'type' => null,
            'extension' => null,
            'address' => null,
            'quality' => null,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
