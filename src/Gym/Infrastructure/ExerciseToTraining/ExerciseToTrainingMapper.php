<?php

declare(strict_types=1);

namespace Gym\Infrastructure\ExerciseToTraining;

use App\DateTimeNormalizer;
use Gym\Domain\Enum\StatusEnum;
use Gym\Domain\ExerciseToTraining\ExerciseToTraining as DomainEntity;
use Gym\Domain\ExerciseToTraining\ExerciseToTrainingDTO;

class ExerciseToTrainingMapper
{
    public static function toDomain(ExerciseToTraining $entity): DomainEntity
    {
        $dto = new ExerciseToTrainingDTO();
        $dto->id = $entity->id;
        $dto->trainingId = $entity->trainingId;
        $dto->exerciseId = $entity->exerciseId;
        $dto->status = StatusEnum::from($entity->status);
        $dto->seriesGoal = $entity->seriesGoal;
        $dto->repetitionGoal = $entity->repetitionGoal;
        $dto->kilogramGoal = $entity->kilogramGoal;
        $dto->createdAt = DateTimeNormalizer::normalizeToImmutable(
            $entity->createdAt
        );

        return new DomainEntity($dto);
    }

    public static function fromDomain(DomainEntity $domainEntity): ExerciseToTraining
    {
        $entity = new ExerciseToTraining();
        $entity->id = $domainEntity->getId();
        $entity->trainingId = $domainEntity->getTrainingId();
        $entity->exerciseId = $domainEntity->getExerciseId();
        $entity->status = $domainEntity->getStatus()->getValue();
        $entity->seriesGoal = $domainEntity->getSeriesGoal();
        $entity->repetitionGoal = $domainEntity->getRepetitionGoal();
        $entity->kilogramGoal = $domainEntity->getKilogramGoal();
        $entity->createdAt = \DateTime::createFromImmutable(
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
            static fn (ExerciseToTraining $entity) => self::toDomain($entity),
            $entities
        );
    }
}
