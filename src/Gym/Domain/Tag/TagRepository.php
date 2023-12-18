<?php

declare(strict_types=1);

namespace Gym\Domain\Tag;

interface TagRepository
{
    /**
     * @return Tag[]
     */
    public function findAllForOwnerId(string $ownerId): array;
}
