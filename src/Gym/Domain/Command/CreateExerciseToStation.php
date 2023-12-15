<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

class CreateExerciseToStation
{
    private string $exerciseId;
    private string $stationId;

    public function __construct(string $exerciseId, string $stationId)
    {
        $this->exerciseId = $exerciseId;
        $this->stationId = $stationId;
    }

    public function getExerciseId(): string
    {
        return $this->exerciseId;
    }

    public function getStationId(): string
    {
        return $this->stationId;
    }
}
