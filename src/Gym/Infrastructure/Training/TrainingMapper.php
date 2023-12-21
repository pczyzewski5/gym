<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Training;

use DateTime;
use Gym\Domain\Enum\StatusEnum;
use Gym\Domain\Training\Training as DomainEntity;
use App\DateTimeNormalizer;
use Gym\Domain\Training\TrainingDTO;

class TrainingMapper
{
    public static function toDomain(Training $entity): DomainEntity
    {
        $trainingStarted = null === $entity->trainingStarted
            ? null
            : DateTimeNormalizer::normalizeToImmutable($entity->trainingStarted);
        $trainingFinished = null === $entity->trainingFinished
            ? null
            : DateTimeNormalizer::normalizeToImmutable($entity->trainingFinished);

        $dto = new TrainingDTO();
        $dto->id = $entity->id;
        $dto->status = StatusEnum::from($entity->status);
        $dto->trainingDate = DateTimeNormalizer::normalizeToImmutable(
            $entity->trainingDate
        );
        $dto->trainingStarted = $trainingStarted;
        $dto->trainingFinished = $trainingFinished;
        $dto->repeated = $entity->repeated;
        $dto->createdAt = DateTimeNormalizer::normalizeToImmutable(
            $entity->createdAt
        );

        return new DomainEntity($dto);
    }

    public static function fromDomain(DomainEntity $domainEntity): Training
    {
        $trainingStarted = null === $domainEntity->getTrainingStarted()
            ? null
            : DateTime::createFromImmutable($domainEntity->getTrainingStarted());
        $trainingFinished = null === $domainEntity->getTrainingFinished()
            ? null
            : DateTime::createFromImmutable($domainEntity->getTrainingFinished());

        $entity = new Training();
        $entity->id = $domainEntity->getId();
        $entity->status = $domainEntity->getStatus()->getValue();
        $entity->trainingDate = DateTime::createFromImmutable(
            $domainEntity->getTrainingDate()
        );
        $entity->trainingStarted = $trainingStarted;
        $entity->trainingFinished = $trainingFinished;
        $entity->repeated = $domainEntity->isRepeated();
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
            static fn (Training $entity) => self::toDomain($entity),
            $entities
        );
    }
}
