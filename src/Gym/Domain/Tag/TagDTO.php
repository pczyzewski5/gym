<?php

declare(strict_types=1);

namespace Gym\Domain\Tag;

use Gym\Domain\Enum\MuscleTagEnum;
use Gym\Domain\Enum\TagOwnerEnum;

class TagDTO
{
    public ?string $ownerId = null;
    public ?TagOwnerEnum $owner = null;
    public ?MuscleTagEnum $tag = null;
}
