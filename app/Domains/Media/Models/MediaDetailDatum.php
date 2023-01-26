<?php

namespace App\Domains\Media\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int|null $media_detail_id
 * @property string|null $name
 * @property string|null $value
 * @property MediaDetail|null $mediaDetail
 */
class MediaDetailDatum extends Model {

    protected $table = 'media_detail_data';

    protected $fillable = [
        'media_detail_id',
        'name',
        'value'
    ];

    public function mediaDetail(): BelongsTo {
        return $this->belongsTo(
            MediaDetail::class,
            'media_detail_id',
            'id',
            'fk-media_detail_data-media_detail_id'
        );
    }
}
