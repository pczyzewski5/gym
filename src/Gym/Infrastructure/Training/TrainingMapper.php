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
        $dto = new TrainingDTO();
        $dto->id = $entity->id;
        $dto->status = StatusEnum::from($entity->status);
        $dto->date = DateTimeNormalizer::normalizeToImmutable(
            $entity->date
        );
        $dto->createdAt = DateTimeNormalizer::normalizeToImmutable(
            $entity->createdAt
        );

        return new DomainEntity($dto);
    }

    public static function fromDomain(DomainEntity $domainEntity): Training
    {
        $entity = new Training();
        $entity->id = $domainEntity->getId();
        $entity->status = $domainEntity->getStatus()->getValue();
        $entity->date = DateTime::createFromImmutable(
            $domainEntity->getDate()
        );
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
