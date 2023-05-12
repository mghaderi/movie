<?php

namespace App\Domains\Media\Services\Factories\DTOs;

use romanzipp\DTO\AbstractData;

/**
 * @property ?string $season
 * @property ?string $episode
 * @property ?MediaFactorySourceLinkData[] $sourceLinks
 */
class MediaFactorySourceData extends AbstractData
{
    public ?string $season;
    public ?string $eposode;
    public ?array $sourceLinks;
}
