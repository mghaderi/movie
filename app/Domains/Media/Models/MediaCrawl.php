<?php

namespace App\Domains\Media\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ?int $page_number
 */
class MediaCrawl extends Model
{

    protected $table = 'media_crawls';

    protected $fillable = [
        'page_number',
    ];
}
