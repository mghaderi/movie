<?php

namespace App\Domains\Word\Services\Factories\DTOs;

use App\Domains\Word\Models\Language;
use romanzipp\DTO\AbstractData;

/**
 * @property Language $language
 * @property string $value
 */
class WordFactoryDTO extends AbstractData
{
    #[Required]
    public Language $language;
    #[Required]
    public string $value;
}
