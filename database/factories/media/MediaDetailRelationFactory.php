<?php

namespace Database\Factories\media;

use App\Domains\Media\Models\MediaDetailRelation;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaDetailRelationFactory extends Factory {

    protected $model = MediaDetailRelation::class;

    public function definition() {
        return [
            'media_detail_id' => null,
            'relation_type' => null,
            'relation_id' => null,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
