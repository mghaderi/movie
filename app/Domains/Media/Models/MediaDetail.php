<?php

namespace App\Domains\Media\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int|null $media_id
 * @property string|null $type
 */
class MediaDetail extends Model {

    protected $table = 'media_details';

    protected $fillable = [
        'media_id',
        'type'
    ];
}
