<?php

namespace App\Domains\Media\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string|null $type
 * @property string|null $extension
 * @property string|null $address
 * @property string|null $quality
 */
class Link extends Model {

    protected $table = 'links';

    protected $fillable = [
        'type',
        'extension',
        'address',
        'quality'
    ];
}
