<?php

namespace App\Domains\Genre\Models;

use App\Models\Traits\IsMorph;
use Database\Factories\genre\GenreFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property ?int $word_id
 * @property ?string $name
 * @property ?Word $word
 */
class Genre extends Model {

    use HasFactory;
    use IsMorph;

    protected $fillable = [
        'word_id',
        'name',
    ];

    public function word(): BelongsTo {
        return $this->belongsTo(
            Word::class,
            'word_id',
            'id',
            'fk-genres-word_id'
        );
    }

    public function scopeFilter(
        Builder $query,
        ?string $name = null,
        ?int $wordId = null
    ): void {
        if (!empty($name)) {
            $query->where('name', $name);
        }
        if (!empty($wordId)) {
            $query->where('word_id', $wordId);
        }
    }

    protected static function newFactory() {
        return GenreFactory::new();
    }
}
