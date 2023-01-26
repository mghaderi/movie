<?php

namespace App\Domains\Word\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string|null $name
 * @property Collection $wordDetailBigs
 * @property Collection $wordDetailSmalls
 */
class Language extends Model
{
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
}
