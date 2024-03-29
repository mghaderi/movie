<?php

namespace App\Domains\Media\Models;

use Database\Factories\media\MediaFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property string|null $tt_name
 * @property string|null $type
 * @property Collection $mediaDetails
 * @property Collection $mediaDetailData
 * @property Collection $mediaDetailRelations
 */
class Media extends Model {

    use HasFactory;

    protected $table = 'medias';

    protected $fillable = [
        'tt_name',
        'type',
        'status'
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

    protected static function newFactory() {
        return MediaFactory::new();
    }

    public function scopeFilter(
        Builder $query,
        ?string $ttName = null,
        ?string $type = null,
        ?string $status = null
    ): void {
        if (!empty($ttName)) {
            $query->where('tt_name', $ttName);
        }
        if (!empty($type)) {
            $query->where('type', $type);
        }
        if (!empty($status)) {
            $query->where('status', $status);
        }
    }
}
