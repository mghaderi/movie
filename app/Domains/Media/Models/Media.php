<?php

namespace App\Domains\Media\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property string|null $tt_name
 * @property string|null $type
 * @property Collection $mediaDetails
 * @property Collection $mediaDetailData
 * @property Collection $mediaDetailRelations
 */
class Media extends Model {

    protected $table = 'medias';

    protected $fillable = [
        'tt_name',
        'type'
    ];

    public function mediaDetails(): HasMany {
        return $this->hasMany(
            MediaDetail::class,
            'media_id',
            'id'
        );
    }

    public function mediaDetailData(): HasManyThrough {
        return $this->hasManyThrough(
            MediaDetailDatum::class,
            MediaDetail::class,
            'media_id',
            'media_detail_id',
            'id',
            'id',
        );
    }

    public function mediaDetailRelations(): HasManyThrough {
        return $this->hasManyThrough(
            MediaDetailRelation::class,
            MediaDetail::class,
            'media_id',
            'media_detail_id',
            'id',
            'id',
        );
    }

}
