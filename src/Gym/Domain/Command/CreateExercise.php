<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\Enum\MuscleTagEnum;
use Gym\Domain\Enum\StatusEnum;

class CreateExercise
{
    private StatusEnum $status;
    private int $seriesTarget;
    private int $targetRepetitions;

    public function __construct(
        StatusEnum $status,
        int $seriesTarget,
        int $targetRepetitions,
    ) {
        $this->status = $status;
        $this->seriesTarget = $seriesTarget;
        $this->targetRepetitions = $targetRepetitions;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function getSeriesTarget(): int
    {
        return $this->seriesTarget;
    }

    public function getTargetRepetitions(): int
    {
        return $this->targetRepetitions;
    }
}
