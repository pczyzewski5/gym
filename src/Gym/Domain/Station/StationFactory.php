<?php

declare(strict_types=1);

namespace Gym\Domain\Station;

use Symfony\Component\Uid\Uuid;

class StationFactory
{
    public static function create(
    string $name,
    string $image
    ): Station {
        $dto = new StationDTO();
        $dto->id = Uuid::v1()->toRfc4122();
        $dto->name = $name;
        $dto->image = $image;

        return new Station($dto);
    }
}
