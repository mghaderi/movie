<?php

namespace App\Domains\Media\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int|null $media_detail_id
 * @property string|null $name
 * @property string|null $value
 * @property MediaDetail|null $mediaDetail
 * @property Collection|null $mediaDetailRelationsData
 * @property Collection|null $mediaDetailRelations
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

    public function mediaDetailRelationsData(): HasMany {
        return $this->hasMany(
            MediaDetailRelationDatum::class,
            'media_detail_data_id',
            'id'
        );
    }

    public function mediaDetailRelations(): BelongsToMany {
        return $this->belongsToMany(
            MediaDetailRelation::class,
            'media_detail_relations_data',
            'media_detail_data_id',
            'media_detail_relations_id',
        );
    }
}
