<?php

namespace App\Domains\Location\Models;

use App\Domains\Word\Models\Word;
use Database\Factories\location\CountryFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int|null $word_id
 * @property string|null $short_name
 * @property Word|null $word
 * @property Collection $cities
 */
class Country extends Model {

    use HasFactory;

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

    protected static function newFactory() {
        return CountryFactory::new();
    }

    public function scopeFilter(
        Builder $query,
        ?string $shortName = null,
        ?int $wordId = null
    ): void {
        if (!empty($shortName)) {
            $query->where('short_name', $shortName);
        }
        if (!empty($wordId)) {
            $query->where('word_id', $wordId);
        }
    }
}
