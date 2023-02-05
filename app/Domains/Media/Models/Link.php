<?php

namespace App\Domains\Media\Models;

use App\Models\Traits\IsMorph;
use Database\Factories\media\LinkFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string|null $type
 * @property string|null $extension
 * @property string|null $address
 * @property string|null $quality
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

    protected static function newFactory() {
        return LinkFactory::new();
    }
}
