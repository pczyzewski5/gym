<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Rest;

use Gym\Domain\Rest\Rest as DomainEntity;
use Gym\Domain\Rest\RestDTO;

class RestMapper
{
    public static function toDomain(Rest $entity): DomainEntity
    {
        $dto = new RestDTO();
        $dto->stationId = $entity->stationId;
        $dto->exerciseId = $entity->exerciseId;
        $dto->rest = $entity->rest;

        return new DomainEntity($dto);
    }

    public static function fromDomain(DomainEntity $domainEntity): Rest
    {
        $entity = new Rest();
        $entity->stationId = $domainEntity->getStationId();
        $entity->exerciseId = $domainEntity->getExerciseId();
        $entity->rest = $domainEntity->getRest();

        return $entity;
    }

    /**
     * @return DomainEntity[]
     */
    public static function mapArrayToDomain(array $entities): array
    {
        return \array_map(
            static fn (Rest $entity) => self::toDomain($entity),
            $entities
        );
    }
}
