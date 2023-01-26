<?php

namespace App\Domains\Word\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int|null $word_id
 * @property int|null $language_id
 * @property string|null $value
 * @property Language|null $language
 * @property Word|null $word
 */
class WordDetailSmall extends Model
{
    protected $table = 'word_detail_smalls';

    protected $fillable = [
        'word_id',
        'language_id',
        'value',
    ];

    public function word(): BelongsTo {
        return $this->belongsTo(
            Word::class,
            'word_id',
            'id',
            'fk-word_detail_smalls-word_id'
        );
    }

    public function language(): BelongsTo {
        return $this->belongsTo(
            Language::class,
            'language_id',
            'id',
            'fk-word_detail_smalls-language_id'
        );
    }
}
