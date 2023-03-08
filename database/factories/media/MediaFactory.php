<?php

namespace Database\Factories\media;

use App\Domains\Media\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory {

    protected $model = Media::class;

    public function definition() {
        return [
            'tt_name' => null,
            'type' => null,
            'status' => null,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
