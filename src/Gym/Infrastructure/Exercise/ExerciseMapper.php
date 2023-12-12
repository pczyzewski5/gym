<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Exercise;

use DateTime;
use Gym\Domain\Exercise\Exercise as DomainEntity;
use App\DateTimeNormalizer;
use Gym\Domain\Exercise\ExerciseDTO;

class ExerciseMapper
{
    public static function toDomain(Exercise $entity): DomainEntity
    {
        $dto = new ExerciseDTO();
        $dto->id = $entity->id;
        $dto->name = $entity->name;
        $dto->status = $entity->status;
        $dto->stationId = $entity->stationId;
        $dto->repetitionTarget = $entity->repetitionTarget;
        $dto->kilogramTarget = $entity->kilogramTarget;
        $dto->createdAt = DateTimeNormalizer::normalizeToImmutable(
            $entity->createdAt
        );

        return new DomainEntity($dto);
    }

    public static function fromDomain(DomainEntity $domainEntity): Exercise
    {
        $entity = new Exercise();
        $entity->id = $domainEntity->getId();
        $entity->name = $domainEntity->getName();
        $entity->status = $domainEntity->getStatus();
        $entity->stationId = $domainEntity->getStationId();
        $entity->repetitionTarget = $domainEntity->getRepetitionTarget();
        $entity->kilogramTarget = $domainEntity->getKilogramTarget();
        $entity->createdAt = DateTime::createFromImmutable(
            $domainEntity->getCreatedAt()
        );

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
