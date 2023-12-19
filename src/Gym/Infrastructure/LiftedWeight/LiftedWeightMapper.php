<?php

declare(strict_types=1);

namespace Gym\Infrastructure\LiftedWeight;

use App\DateTimeNormalizer;
use Gym\Domain\LiftedWeight\LiftedWeight as DomainEntity;
use Gym\Domain\LiftedWeight\LiftedWeightDTO;

class LiftedWeightMapper
{
    public static function toDomain(LiftedWeight $entity): DomainEntity
    {
        $dto = new LiftedWeightDTO();
        $dto->id = $entity->id;
        $dto->trainingId = $entity->trainingId;
        $dto->stationId = $entity->stationId;
        $dto->exerciseId = $entity->exerciseId;
        $dto->repetitionCount = $entity->repetitionCount;
        $dto->kilogramCount = $entity->kilogramCount;
        $dto->createdAt = DateTimeNormalizer::normalizeToImmutable(
            $entity->createdAt
        );

        return new DomainEntity($dto);
    }

    public static function fromDomain(DomainEntity $domainEntity): LiftedWeight
    {
        $entity = new LiftedWeight();
        $entity->id = $domainEntity->getId();
        $entity->trainingId = $domainEntity->getTrainingId();
        $entity->stationId = $domainEntity->getStationId();
        $entity->exerciseId = $domainEntity->getExerciseId();
        $entity->repetitionCount = $domainEntity->getRepetitionCount();
        $entity->kilogramCount = $domainEntity->getKilogramCount();
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
            static fn (LiftedWeight $entity) => self::toDomain($entity),
            $entities
        );
    }
}
