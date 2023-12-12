<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Tag;

use Gym\Domain\Tag\Tag as DomainEntity;
use Gym\Domain\Tag\TagDTO;

class TagMapper
{
    public static function toDomain(Tag $entity): DomainEntity
    {
        $dto = new TagDTO();
        $dto->ownerId = $entity->ownerId;
        $dto->owner = $entity->owner;
        $dto->tag = $entity->tag;

        return new DomainEntity($dto);
    }

    public static function fromDomain(DomainEntity $domainEntity): Tag
    {
        $entity = new Tag();
        $entity->ownerId = $domainEntity->getOwnerId();
        $entity->owner = $domainEntity->getOwner()->getValue();
        $entity->tag = $domainEntity->getTag()->getValue();

        return $entity;
    }

    /**
     * @return DomainEntity[]
     */
    public static function mapArrayToDomain(array $entities): array
    {
        return \array_map(
            static fn (Tag $entity) => self::toDomain($entity),
            $entities
        );
    }
}
