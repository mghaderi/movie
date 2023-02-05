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

    protected static function newFactory() {
        return LinkFactory::new();
    }
}
