<?php

namespace App\Domains\Media\Services\Factories\DTOs;

use romanzipp\DTO\AbstractData;

/**
 * @property ?string $url
 * @property ?string $type
 * @property ?string $name
 */
class MediaFactoryImageData extends AbstractData
{
    public ?string $url;
    public ?string $type;
    public ?string $name;
}
