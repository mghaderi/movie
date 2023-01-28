<?php

namespace App\Domains\Media\Services;

use App\Domains\Media\Models\Link;

class LinkService
{
    public Link|null $link;

    public function __construct(Link|null $link = null) {
        $this->link = $link;
    }

    public function linkTypes(): array {
        return [
            'movie',
            'image',
        ];
    }


}
