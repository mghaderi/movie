<?php

namespace App\Domains\Media\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model {

    protected $fillable = [
        'tt_name',
        'type'
    ];
}
