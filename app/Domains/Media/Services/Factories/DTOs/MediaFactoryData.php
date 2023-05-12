<?php

namespace App\Domains\Media\Services\Factories\DTOs;

use romanzipp\DTO\AbstractData;

/**
 * @property ?string $title
 * @property ?string $ttName
 * @property ?string $status
 * @property ?MediaFactoryImageData[] $mediaFactoryImages
 * @property ?string[] $actors
 * @property ?string[] $countries
 * @property ?string[] $directors
 * @property ?string[] $genres
 * @property ?string[] $languages
 * @property ?string[] $releases
 * @property ?string[] $categories
 * @property ?string $rate
 * @property ?string $score
 * @property ?array[] $others
 * @property ?MediaFactorySourceData[] $sources
 */
class MediaFactoryData extends AbstractData
{
    public ?string $title;
    public ?string $ttName;
    public ?string $status;
    public ?array $mediaFactoryImages;
    public ?array $actors;
    public ?array $counties;
    public ?array $directors;
    public ?array $genres;
    public ?array $languages;
    public ?array $releases;
    public ?array $categories;
    public ?string $rate;
    public ?string $score;
    public ?array $others;
    public ?array $sources;
}
