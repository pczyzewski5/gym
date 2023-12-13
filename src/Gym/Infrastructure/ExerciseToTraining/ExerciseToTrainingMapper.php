<?php

declare(strict_types=1);

namespace Gym\Infrastructure\ExerciseToTraining;

use Gym\Domain\ExerciseToTraining\ExerciseToTraining as DomainEntity;
use Gym\Domain\ExerciseToTraining\ExerciseToTrainingDTO;

class ExerciseToTrainingMapper
{
    public static function toDomain(ExerciseToTraining $entity): DomainEntity
    {
        $dto = new ExerciseToTrainingDTO();
        $dto->exerciseId = $entity->exerciseId;
        $dto->trainingId = $entity->trainingId;

        return new DomainEntity($dto);
    }

    public static function fromDomain(DomainEntity $domainEntity): ExerciseToTraining
    {
        $entity = new ExerciseToTraining();
        $entity->exerciseId = $domainEntity->getExerciseId();
        $entity->trainingId = $domainEntity->getTrainingId();

        return $entity;
    }

    /**
     * @return DomainEntity[]
     */
    public static function mapArrayToDomain(array $entities): array
    {
        return \array_map(
            static fn (ExerciseToTraining $entity) => self::toDomain($entity),
            $entities
        );
    }
}
