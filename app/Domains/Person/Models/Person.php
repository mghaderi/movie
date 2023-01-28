<?php

namespace App\Domains\Person\Models;

use App\Domains\Word\Models\Word;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int|null $first_name_word_id
 * @property int|null $last_name_word_id
 * @property int|null $full_name_word_id
 * @property Word|null $firstName
 * @property Word|null $lastName
 * @property Word|null $fullName
 */
class Person extends Model {

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
}
