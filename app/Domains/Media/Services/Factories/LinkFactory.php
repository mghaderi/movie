<?php

namespace App\Domains\Media\Services\Factories;

use App\Domains\Media\Models\Link;
use App\Domains\Media\Services\LinkService;

class LinkFactory
{
    public function generate(string $type, string $address, string $extension, string $quality): Link
    {
        $linkService = new LinkService();
        $linkService->setLink($linkService->fetchOrCreateLink());
        $linkService->setLinkType($type);
        $linkService->setLinkData($address, $extension, $quality);
        $linkService->saveLink();
        return $linkService->fetchOrCreateLink();
    }
}
