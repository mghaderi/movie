<?php

namespace App\Domains\Location\Models;

use App\Domains\Word\Models\Word;
use Database\Factories\location\CityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int|null $word_id
 * @property string|null $short_name
 * @property Word|null $word
 * @property Country|null $country
 */
class City extends Model {

    use HasFactory;

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

    protected static function newFactory() {
        return CityFactory::new();
    }
}
