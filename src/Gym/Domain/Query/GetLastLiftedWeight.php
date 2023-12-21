<?php

declare(strict_types=1);

namespace Gym\Domain\Query;

class GetLastLiftedWeight
{
    private string $stationId;
    private string $exerciseId;

    public function __construct(string $stationId, string $exerciseId)
    {
        $this->stationId = $stationId;
        $this->exerciseId = $exerciseId;
    }

    public function getStationId(): string
    {
        return $this->stationId;
    }

    public function getExerciseId(): string
    {
        return $this->exerciseId;
    }
}
