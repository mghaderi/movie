<?php

namespace App\Domains\Person\Services\Factories\DTOs;

use Illuminate\Database\Eloquent\Model;
use romanzipp\DTO\AbstractData;

/**
 * @property Model $relation
 * @property string $type
 */
class PersonFactoryDTO extends AbstractData
{
    #[Required]
    public Model $relation;
    #[Required]
    public string $type;
}
