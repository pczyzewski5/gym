<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Exercise;

use Gym\Domain\Exercise\Exercise as DomainEntity;
use Gym\Domain\Exercise\ExerciseDTO;

class ExerciseMapper
{
    public static function toDomain(Exercise $entity): DomainEntity
    {
        $dto = new ExerciseDTO();
        $dto->id = $entity->id;
        $dto->name = $entity->name;
        $dto->description = $entity->description;
        $dto->image = $entity->image;

        return new DomainEntity($dto);
    }

    public static function fromDomain(DomainEntity $domainEntity): Exercise
    {
        $entity = new Exercise();
        $entity->id = $domainEntity->getId();
        $entity->name = $domainEntity->getName();
        $entity->description = $domainEntity->getDescription();
        $entity->image = $domainEntity->getImage();

        return $entity;
    }

    /**
     * @return DomainEntity[]
     */
    public static function mapArrayToDomain(array $entities): array
    {
        return \array_map(
            static fn (Exercise $entity) => self::toDomain($entity),
            $entities
        );
    }
}
