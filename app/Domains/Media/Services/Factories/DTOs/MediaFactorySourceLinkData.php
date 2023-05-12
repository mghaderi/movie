<?php

namespace App\Domains\Media\Services\Factories\DTOs;

use romanzipp\DTO\AbstractData;

/**
 * @property string $link
 * @property string $quality
 */
class MediaFactorySourceLinkData extends AbstractData
{
    public ?string $link;
    public ?string $quality;
}
