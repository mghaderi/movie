<?php

namespace App\Domains\Location\Models;

use App\Domains\Word\Models\Word;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int|null $word_id
 * @property int|null $short_name
 * @property Word|null $word
 */
class Country extends Model {

    protected $table = 'countries';

    protected $fillable = [
        'word_id',
        'short_name',
    ];

    public function word(): BelongsTo {
        return $this->belongsTo(
            Word::class,
            'word_id',
            'id',
            'fk-countries-word_id'
        );
    }

    public function cities(): HasMany {
        return $this->hasMany(
            City::class,
            'country_id',
            'id'
        );
    }
}
