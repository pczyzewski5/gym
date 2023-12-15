<?php

declare(strict_types=1);

namespace Gym\Domain\ExerciseToStation;

class ExerciseToStationFactory
{
    public static function create(
        string $exerciseId,
        string $stationId
    ): ExerciseToStation {
        $dto = new ExerciseToStationDTO();
        $dto->exerciseId = $exerciseId;
        $dto->stationId = $stationId;

        return new ExerciseToStation($dto);
    }
}
