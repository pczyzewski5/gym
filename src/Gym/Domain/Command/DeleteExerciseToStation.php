<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

class DeleteExerciseToStation
{
   private string $stationId;

    public function __construct(string $stationId)
    {
         $this->stationId = $stationId;
    }

    public function getStationId(): string
    {
        return $this->stationId;
    }
}
