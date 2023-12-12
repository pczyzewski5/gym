<?php

declare(strict_types=1);

namespace Gym\Domain\Tag;

use Gym\Domain\Enum\MuscleTagEnum;
use Gym\Domain\Enum\TagOwnerEnum;

class TagFactory
{
    public static function create(
        string $ownerId,
        TagOwnerEnum $owner,
        MuscleTagEnum $tag,
    ): Tag {
        $dto = new TagDTO();
        $dto->ownerId = $ownerId;
        $dto->owner = $owner;
        $dto->tag = $tag;

        return new Tag($dto);
    }
}
