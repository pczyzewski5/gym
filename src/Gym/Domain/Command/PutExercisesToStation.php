<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

class PutExercisesToStation
{
    private string $stationId;
    private array $exerciseIds;

    public function __construct(string $stationId, array $exerciseIds)
    {
        $this->stationId = $stationId;
        $this->exerciseIds = $exerciseIds;
    }

    public function getStationId(): string
    {
        return $this->stationId;
    }

    public function getExerciseIds(): array
    {
        return $this->exerciseIds;
    }
}
