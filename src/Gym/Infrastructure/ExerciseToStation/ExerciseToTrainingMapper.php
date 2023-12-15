<?php

declare(strict_types=1);

namespace Gym\Infrastructure\ExerciseToStation;

use Gym\Domain\ExerciseToStation\ExerciseToStation as DomainEntity;
use Gym\Domain\ExerciseToStation\ExerciseToStationDTO;

class ExerciseToTrainingMapper
{
    public static function toDomain(ExerciseToStation $entity): DomainEntity
    {
        $dto = new ExerciseToStationDTO();
        $dto->exerciseId = $entity->exerciseId;
        $dto->stationId = $entity->stationId;

        return new DomainEntity($dto);
    }

    public static function fromDomain(DomainEntity $domainEntity): ExerciseToStation
    {
        $entity = new ExerciseToStation();
        $entity->exerciseId = $domainEntity->getExerciseId();
        $entity->stationId = $domainEntity->getStationId();

        return $entity;
    }

    /**
     * @return DomainEntity[]
     */
    public static function mapArrayToDomain(array $entities): array
    {
        return \array_map(
            static fn (ExerciseToStation $entity) => self::toDomain($entity),
            $entities
        );
    }
}
