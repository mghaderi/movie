<?php

namespace App\Domains\Media\Models;

use App\Domains\Word\Models\Language;
use App\Domains\Word\Models\Word;
use Database\Factories\media\MediaDetailFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property int|null $media_id
 * @property string|null $type
 * @property Media|null $media
 * @property Collection $mediaDetailData
 * @property Collection $mediaDetailRelation
 * @property Collection $words
 * @property Collection $links
 * @property Collection $languages
 */
class MediaDetail extends Model {

    use HasFactory;

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

    public function mediaDetailRelations(): HasMany {
        return $this->hasMany(
            MediaDetailRelation::class,
            'media_detail_id',
            'id'
        );
    }

    public function words(): MorphToMany {
        return $this->morphedByMany(
            Word::class,
            'relation',
            'media_detail_relations'
        );
    }

    public function links(): MorphToMany {
        return $this->morphedByMany(
            Link::class,
            'relation',
            'media_detail_relations'
        );
    }

    public function languages(): MorphToMany {
        return $this->morphedByMany(
            Language::class,
            'relation',
            'media_detail_relations'
        );
    }

    protected static function newFactory() {
        return MediaDetailFactory::new();
    }
}
