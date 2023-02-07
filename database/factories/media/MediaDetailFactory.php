<?php

namespace Database\Factories\media;

use App\Domains\Media\Models\Link;
use App\Domains\Media\Models\MediaDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaDetailFactory extends Factory {

    protected $model = MediaDetail::class;

    public function definition() {
        return [
            'media_id' => null,
            'type' => null,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
