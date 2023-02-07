<?php

namespace App\Domains\Word\Models;

use App\Domains\Media\Models\MediaDetail;
use App\Domains\Media\Models\MediaDetailRelation;
use App\Models\Traits\IsMorph;
use Database\Factories\word\LanguageFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property string|null $name
 * @property Collection $wordDetailBigs
 * @property Collection $wordDetailSmalls
 * @property Collection $mediaDetailRelations
 * @property Collection $mediaDetail
 */
class Language extends Model {

    use HasFactory;
    use IsMorph;

    protected $table = 'languages';

    protected $fillable = [
        'name'
    ];

    public function wordDetailBigs(): HasMany {
        return $this->hasMany(
            WordDetailBig::class,
            'language_id',
            'id'
        );
    }

    public function wordDetailSmalls(): HasMany {
        return $this->hasMany(
            WordDetailSmall::class,
            'language_id',
            'id'
        );
    }

    public function mediaDetailRelations(): MorphMany {
        return $this->morphMany(
            MediaDetailRelation::class,
            'relation',
            'relation_type',
            'relation_id',
        );
    }

    public function mediaDetails(): MorphToMany {
        return $this->morphToMany(
            MediaDetail::class,
            'relation',
            'media_detail_relations'
        );
    }

    protected static function newFactory() {
        return LanguageFactory::new();
    }
}
