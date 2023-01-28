<?php

namespace App\Domains\Person\Models;

use App\Domains\Media\Models\Link;
use App\Domains\Word\Models\Word;
use App\Models\Interfaces\MorphInterface;
use App\Models\Traits\HasMorph;
use App\Services\PossibleMorphService;
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
class PersonDetail extends Model implements MorphInterface {

    use HasMorph;

    protected $table = 'persons';

    protected $fillable = [
        'person_id',
        'type',
        'relation_type',
        'relation_id',
    ];

    public function person(): BelongsTo {
        return $this->belongsTo(
            Word::class,
            'person_id',
            'id',
            'fk-person_details-person_id'
        );
    }

    public function setPossibleMorphClasses(PossibleMorphService $possibleMorphService): PossibleMorphService {
        $possibleMorphService->setPossibleMorphs(
            Word::class,
            Link::class
        );
        return $possibleMorphService;
    }
}
