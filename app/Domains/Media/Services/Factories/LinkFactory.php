<?php

namespace App\Domains\Media\Services\Factories;

use App\Domains\Media\Models\Link;
use App\Domains\Media\Services\LinkService;

class LinkFactory
{
    public LinkService $linkService;

    public function __construct()
    {
        $this->linkService = new LinkService();
    }

    public function generate(string $type, string $address, string $extension, string $quality): Link
    {
        $this->linkService->setLink($this->linkService->fetchOrCreateLink());
        $this->linkService->setLinkType($type);
        $this->linkService->setLinkAddress($address);
        $this->linkService->setLinkExtension($extension);
        $this->linkService->setLinkQuality($quality);
        $this->linkService->saveLink();
        return $this->linkService->fetchOrCreateLink();
    }
}
