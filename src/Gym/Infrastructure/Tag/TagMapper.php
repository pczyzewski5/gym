<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Tag;

use Gym\Domain\Enum\MuscleTagEnum;
use Gym\Domain\Enum\TagOwnerEnum;
use Gym\Domain\Tag\Tag as DomainEntity;
use Gym\Domain\Tag\TagDTO;

class TagMapper
{
    public static function toDomain(Tag $entity): DomainEntity
    {
        $dto = new TagDTO();
        $dto->id = $entity->ownerId;
        $dto->ownerId = $entity->ownerId;
        $dto->owner = TagOwnerEnum::from($entity->owner);
        $dto->tag = MuscleTagEnum::from($entity->tag);

        return new DomainEntity($dto);
    }

    public static function fromDomain(DomainEntity $domainEntity): Tag
    {
        $entity = new Tag();
        $entity->id = $domainEntity->getId();
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
