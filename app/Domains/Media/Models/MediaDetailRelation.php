<?php

namespace App\Domains\Media\Models;

use App\Domains\Word\Models\Language;
use App\Domains\Word\Models\Word;
use App\Models\Interfaces\MorphInterface;
use App\Models\Traits\HasMorph;
use App\Services\PossibleMorphService;
use Database\Factories\media\MediaDetailRelationFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int|null $media_detail_id
 * @property string|null $relation_type
 * @property int|null $relation_id
 * @property MediaDetail|null $mediaDetail
 * @property Collection|null $mediaDetailRelationsData
 * @property Collection|null $mediaDetailData
 */
class MediaDetailRelation extends Model implements MorphInterface {

    use HasMorph;
    use HasFactory;

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

    public function mediaDetailRelationsData(): HasMany {
        return $this->hasMany(
            MediaDetailRelationDatum::class,
            'media_detail_relation_id',
            'id'
        );
    }

    public function mediaDetailData(): BelongsToMany {
        return $this->belongsToMany(
            MediaDetailDatum::class,
            'media_detail_relations_data',
            'media_detail_relation_id',
            'media_detail_datum_id',
        );
    }

    public function setPossibleMorphClasses(PossibleMorphService $possibleMorphService): PossibleMorphService {
        $possibleMorphService->setPossibleMorphs(
            Language::class,
            Word::class,
            Link::class,
        );
        return $possibleMorphService;
    }

    protected static function newFactory() {
        return MediaDetailRelationFactory::new();
    }
}
