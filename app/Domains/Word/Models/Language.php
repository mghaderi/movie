<?php

namespace App\Domains\Word\Models;

use App\Models\Traits\IsMorph;
use Database\Factories\word\LanguageFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string|null $name
 * @property Collection $wordDetailBigs
 * @property Collection $wordDetailSmalls
 */
class Language extends Model {

    use HasFactory;
    use IsMorph;

    protected $table = 'languages';

    protected $fillable = [
        'name'
    ];

    public function wordDetailBigs(): HasMany {
        return $this->hasMany(
            WordDetailBig::class,
            'language_id',
            'id'
        );
    }

    public function wordDetailSmalls(): HasMany {
        return $this->hasMany(
            WordDetailSmall::class,
            'language_id',
            'id'
        );
    }

    protected static function newFactory() {
        return LanguageFactory::new();
    }
}
