<?php

namespace Database\Factories\media;

use App\Domains\Media\Models\MediaDetailRelationDatum;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaDetailRelationDatumFactory extends Factory {

    protected $model = MediaDetailRelationDatum::class;

    public function definition() {
        return [
            'media_detail_datum_id' => null,
            'media_detail_relation_id' => null,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
