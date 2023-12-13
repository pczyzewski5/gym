<?php

namespace Gym\Domain\Tag;

use Gym\Domain\Enum\TagOwnerEnum;
use Gym\Domain\Exception\PersisterException;
use Gym\Domain\Tag\Tag as DomainEntity;

interface TagPersister
{
    /**
     * @throws PersisterException
     */
    public function save(DomainEntity $domainEntity): void;

    /**
     * @throws PersisterException
     */
    public function deleteMany(string $ownerId, TagOwnerEnum $owner): void;
}
