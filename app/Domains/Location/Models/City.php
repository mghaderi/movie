<?php

namespace App\Domains\Location\Models;

use App\Domains\Word\Models\Word;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int|null $word_id
 * @property int|null $short_name
 * @property Word|null $word
 * @property Country|null $country
 */
class City extends Model {

    protected $table = 'countries';

    protected $fillable = [
        'word_id',
        'country_id',
        'short_name',
    ];

    public function word(): BelongsTo {
        return $this->belongsTo(
            Word::class,
            'word_id',
            'id',
            'fk-cities-word_id'
        );
    }

    public function country(): BelongsTo {
        return $this->belongsTo(
            Country::class,
            'country_id',
            'id',
            'fk-countries-country_id'
        );
    }
}
