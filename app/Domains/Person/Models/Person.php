<?php

namespace App\Domains\Person\Models;

use App\Domains\Media\Models\Link;
use App\Domains\Word\Models\Word;
use Database\Factories\person\PersonFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property int|null $first_name_word_id
 * @property int|null $last_name_word_id
 * @property int|null $full_name_word_id
 * @property Word|null $firstNameWord
 * @property Word|null $lastNameWord
 * @property Word|null $fullNameWord
 * @property Collection $words
 * @property Collection $links
 * @property Collection $personDetails
 */
class Person extends Model {

    use HasFactory;

    protected $table = 'persons';

    protected $fillable = [
        'first_name_word_id',
        'last_name_word_id',
        'full_name_word_id',
    ];

    public function firstNameWord(): BelongsTo {
        return $this->belongsTo(
            Word::class,
            'first_name_word_id',
            'id',
            'fk-persons-first_name_word_id'
        );
    }

    public function lastNameWord(): BelongsTo {
        return $this->belongsTo(
            Word::class,
            'last_name_word_id',
            'id',
            'fk-persons-last_name_word_id'
        );
    }

    public function fullNameWord(): BelongsTo {
        return $this->belongsTo(
            Word::class,
            'full_name_word_id',
            'id',
            'fk-persons-full_name_word_id'
        );
    }

    public function personDetails(): HasMany {
        return $this->hasMany(
            PersonDetail::class,
            'person_id',
            'id'
        );
    }

    public function words(): MorphToMany {
        return $this->morphedByMany(
            Word::class,
            'relation',
            'person_details'
        );
    }

    public function links(): MorphToMany {
        return $this->morphedByMany(
            Link::class,
            'relation',
            'person_details'
        );
    }

    protected static function newFactory() {
        return PersonFactory::new();
    }
}
