<?php

namespace App\Domains\Media\Models;

use App\Domains\Person\Models\Person;
use App\Domains\Person\Models\PersonDetail;
use App\Models\Traits\IsMorph;
use Database\Factories\media\LinkFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property string|null $type
 * @property string|null $extension
 * @property string|null $address
 * @property string|null $quality
 * @property Collection $personDetails
 * @property Collection $persons
 * @property Collection $mediaDetailRelations
 * @property Collection $mediaDetails
 */
class Link extends Model {

    use IsMorph;
    use HasFactory;

    protected $table = 'links';

    protected $fillable = [
        'type',
        'extension',
        'address',
        'quality'
    ];

    public function personDetails(): MorphMany {
        return $this->morphMany(
            PersonDetail::class,
            'relation',
            'relation_type',
            'relation_id'
        );
    }

    public function persons(): MorphToMany {
        return $this->morphToMany(
            Person::class,
            'relation',
            'person_details'
        );
    }

    public function mediaDetailRelations(): MorphMany {
        return $this->morphMany(
            MediaDetailRelation::class,
            'relation',
            'relation_type',
            'relation_id'
        );
    }

    public function mediaDetails(): MorphToMany {
        return $this->morphToMany(
            MediaDetail::class,
            'relation',
            'media_detail_relations'
        );
    }

    protected static function newFactory() {
        return LinkFactory::new();
    }
}
