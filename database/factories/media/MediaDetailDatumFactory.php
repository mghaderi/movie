<?php

namespace Database\Factories\media;

use App\Domains\Media\Models\MediaDetailDatum;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaDetailDatumFactory extends Factory {

    protected $model = MediaDetailDatum::class;

    public function definition() {
        return [
            'media_detail_id' => null,
            'name' => null,
            'value' => null,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
