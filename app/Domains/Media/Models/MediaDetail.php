<?php

namespace App\Domains\Media\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int|null $media_id
 * @property string|null $type
 * @property Media|null $media
 * @property Collection $mediaDetailData
 */
class MediaDetail extends Model {

    protected $table = 'media_details';

    protected $fillable = [
        'media_id',
        'type'
    ];

    public function media(): BelongsTo {
        return $this->belongsTo(
            Media::class,
            'media_id',
            'id',
            'fk-media_details-media_id'
        );
    }

    public function mediaDetailData(): HasMany {
        return $this->hasMany(
            MediaDetailDatum::class,
            'media_detail_id',
            'id'
        );
    }
}
