<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\Enum\MuscleTagEnum;
use Gym\Domain\Enum\TagOwnerEnum;

class PutTags
{
    private string $ownerId;
    private TagOwnerEnum $owner;
    private array $tags;

    public function __construct(
        string $ownerId,
        TagOwnerEnum $owner,
        array $tags
    ) {
        $this->ownerId = $ownerId;
        $this->owner = $owner;
        $this->tags = $tags;
    }

    public function getOwnerId(): string
    {
        return $this->ownerId;
    }

    public function getOwner(): TagOwnerEnum
    {
        return $this->owner;
    }

    /**
     * @return MuscleTagEnum[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }
}
