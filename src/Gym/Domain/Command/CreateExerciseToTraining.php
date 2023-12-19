<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\Enum\StatusEnum;

class CreateExerciseToTraining
{
    private string $trainingId;
    private string $stationId;
    private string $exerciseId;
    private StatusEnum $status;
    private int $seriesGoal;
    private int $repetitionGoal;
    private int $kilogramGoal;

    public function __construct(
        string $trainingId,
        string $stationId,
        string $exerciseId,
        StatusEnum $status,
        int $seriesGoal,
        int $repetitionGoal,
        int $kilogramGoal
    ) {
        $this->trainingId = $trainingId;
        $this->stationId = $stationId;
        $this->exerciseId = $exerciseId;
        $this->status = $status;
        $this->seriesGoal = $seriesGoal;
        $this->repetitionGoal = $repetitionGoal;
        $this->kilogramGoal = $kilogramGoal;
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

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function getSeriesGoal(): int
    {
        return $this->seriesGoal;
    }

    public function getRepetitionGoal(): int
    {
        return $this->repetitionGoal;
    }

    public function getKilogramGoal(): int
    {
        return $this->kilogramGoal;
    }
}
