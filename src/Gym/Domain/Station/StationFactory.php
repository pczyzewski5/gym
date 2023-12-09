<?php

declare(strict_types=1);

namespace Gym\Domain\Station;

class StationFactory
{
    public static function create(
    string $id,
    string $name,
    string $photoId
    ): Station {
        $dto = new StationDTO();
        $dto->id = $id;
        $dto->name = $name;
        $dto->photoId = $photoId;
        $dto->createdAt = new \DateTimeImmutable();

        return new Station($dto);
    }
}
