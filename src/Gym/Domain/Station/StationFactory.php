<?php

declare(strict_types=1);

namespace Gym\Domain\Station;

use Symfony\Component\Uid\Uuid;

class StationFactory
{
    public static function create(
    string $name,
    string $photoId
    ): Station {
        $dto = new StationDTO();
        $dto->id = Uuid::v1()->toRfc4122();
        $dto->name = $name;
        $dto->photo = $photoId;
        $dto->createdAt = new \DateTimeImmutable();

        return new Station($dto);
    }
}
