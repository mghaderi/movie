<?php

namespace App\Domains\Media\Models;

use App\Models\Traits\IsMorph;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string|null $type
 * @property string|null $extension
 * @property string|null $address
 * @property string|null $quality
 */
class Link extends Model {

    use IsMorph;

    protected $table = 'links';

    protected $fillable = [
        'type',
        'extension',
        'address',
        'quality'
    ];
}
