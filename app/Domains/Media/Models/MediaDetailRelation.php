<?php

namespace App\Domains\Media\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int|null $media_detail_id
 * @property string|null $relation_type
 * @property int|null $relation_id
 * @property MediaDetail|null $mediaDetail
 */
class MediaDetailRelation extends Model {

    protected $table = 'media_detail_relations';

    protected $fillable = [
        'media_detail_id',
        'relation_type',
        'relation_id'
    ];

    public function mediaDetail(): BelongsTo {
        return $this->belongsTo(
            MediaDetail::class,
            'media_detail_id',
            'id',
            'fk-media_detail_relations-media_detail_id'
        );
    }
}
