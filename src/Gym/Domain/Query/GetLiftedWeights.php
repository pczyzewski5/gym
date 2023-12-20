<?php

declare(strict_types=1);

namespace Gym\Domain\Query;

class GetLiftedWeights
{
    private string $trainingId;
    private string $stationId;
    private string $exerciseId;

    public function __construct(
        string $trainingId,
        string $stationId,
        string $exerciseId,
    ) {
        $this->trainingId = $trainingId;
        $this->stationId = $stationId;
        $this->exerciseId = $exerciseId;
    }

    public function getTrainingId(): string
    {
        return $this->trainingId;
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
