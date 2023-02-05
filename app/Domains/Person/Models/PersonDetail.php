<?php

namespace App\Domains\Person\Models;

use App\Domains\Media\Models\Link;
use App\Domains\Word\Models\Word;
use App\Models\Interfaces\MorphInterface;
use App\Models\Traits\HasMorph;
use App\Services\PossibleMorphService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int|null $person_id
 * @property string|null $type
 * @property string|null $relation_type
 * @property int|null $relation_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property Person|null $person
 */
class PersonDetail extends Model implements MorphInterface {

    use HasMorph;

    protected $table = 'person_details';

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

    public function relation(): MorphTo {
        return $this->morphTo(__FUNCTION__, 'relation_type', 'relation_id', 'id');
    }

    public function setPossibleMorphClasses(PossibleMorphService $possibleMorphService): PossibleMorphService {
        $possibleMorphService->setPossibleMorphs(
            Word::class,
            Link::class
        );
        return $possibleMorphService;
    }
}
