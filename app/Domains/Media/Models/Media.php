<?php

namespace App\Domains\Media\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string|null $tt_name
 * @property string|null $type
 */
class Media extends Model {

    protected $table = 'medias';

    protected $fillable = [
        'tt_name',
        'type'
    ];
}
