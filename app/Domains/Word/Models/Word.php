<?php

namespace App\Domains\Word\Models;

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

    protected static function newFactory() {
        return WordFactory::new();
    }
}
