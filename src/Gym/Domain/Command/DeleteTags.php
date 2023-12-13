<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\Enum\TagOwnerEnum;

class DeleteTags
{
    private string $ownerId;
    private TagOwnerEnum $owner;

    public function __construct(
        string $ownerId,
        TagOwnerEnum $owner
    ) {
        $this->ownerId = $ownerId;
        $this->owner = $owner;
    }

    public function getOwnerId(): string
    {
        return $this->ownerId;
    }

    public function getOwner(): TagOwnerEnum
    {
        return $this->owner;
    }
}
