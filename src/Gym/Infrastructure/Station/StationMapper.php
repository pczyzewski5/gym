<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Station;

use DateTime;
use Gym\Domain\Station\Station as DomainEntity;
use App\DateTimeNormalizer;
use Gym\Domain\Station\StationDTO;

class StationMapper
{
    public static function toDomain(Station $entity): DomainEntity
    {
        $dto = new StationDTO();
        $dto->id = $entity->id;
        $dto->name = $entity->name;
        $dto->photoId = $entity->photoId;
        $dto->createdAt = DateTimeNormalizer::normalizeToImmutable(
            $entity->createdAt
        );

        return new DomainEntity($dto);
    }

    public static function fromDomain(DomainEntity $domainEntity): Station
    {
        $entity = new Station();
        $entity->id = $domainEntity->getId();
        $entity->name = $domainEntity->getName();
        $entity->photoId = $domainEntity->getPhotoId();
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
            static fn (Station $entity) => self::toDomain($entity),
            $entities
        );
    }
}
