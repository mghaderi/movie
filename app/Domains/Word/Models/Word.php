<?php

namespace App\Domains\Word\Models;

use App\Models\Traits\IsMorph;
use Database\Factories\word\WordFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string|null $type
 * @property Collection $wordDetailBigs
 * @property Collection $wordDetailSmalls
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

    protected static function newFactory() {
        return WordFactory::new();
    }
}
