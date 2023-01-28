<?php

namespace App\Domains\Media\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int|null $media_detail_data_id
 * @property int|null $media_detail_relations_id
 * @property MediaDetailDatum|null $mediaDetailDatum
 * @property MediaDetailRelation|null $mediaDetailRelation
 */
class MediaDetailRelationDatum extends Model {

    protected $table = 'media_detail_relations_data';

    protected $fillable = [
        'media_detail_datum_id',
        'media_detail_relation_id',
    ];

    public function mediaDetailDatum(): BelongsTo {
        return $this->belongsTo(
            MediaDetailDatum::class,
            'media_detail_datum_id',
            'id',
            'fk-media_detail_relations_data-media_detail_datum_id'
        );
    }

    public function mediaDetailRelation(): BelongsTo {
        return $this->belongsTo(
            MediaDetailRelation::class,
            'media_detail_relation_id',
            'id',
            'fk-media_detail_relations_data-media_detail_relation_id'
        );
    }
}
