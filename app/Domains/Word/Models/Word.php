<?php

namespace App\Domains\Word\Models;

use App\Domains\Location\Models\City;
use App\Domains\Location\Models\Country;
use App\Domains\Media\Models\MediaDetail;
use App\Domains\Media\Models\MediaDetailRelation;
use App\Domains\Person\Models\Person;
use App\Domains\Person\Models\PersonDetail;
use App\Models\Traits\IsMorph;
use Database\Factories\word\WordFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property string|null $type
 * @property Collection $wordDetailBigs
 * @property Collection $wordDetailSmalls
 * @property Collection $personDetails
 * @property Collection $persons
 * @property Collection $mediaDetailRelations
 * @property Collection $mediaDetails
 */
class Word extends Model {

    use HasFactory;
    use IsMorph;

    protected $table = 'words';

    protected $fillable = [
        'type'
    ];

    public function wordDetailBigs(): HasMany {
        return $this->hasMany(
            WordDetailBig::class,
            'word_id',
            'id'
        );
    }

    public function wordDetailSmalls(): HasMany {
        return $this->hasMany(
            WordDetailSmall::class,
            'word_id',
            'id'
        );
    }

    public function cities(): HasMany {
        return $this->hasMany(
            City::class,
            'word_id',
            'id'
        );
    }

    public function countries(): HasMany {
        return $this->hasMany(
            Country::class,
            'word_id',
            'id'
        );
    }

    public function personDetails(): MorphMany {
        return $this->morphMany(
            PersonDetail::class,
            'relation',
            'relation_type',
            'relation_id',
        );
    }

    public function persons(): MorphToMany {
        return $this->morphToMany(
            Person::class,
            'relation',
            'person_details'
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
        return WordFactory::new();
    }
}
