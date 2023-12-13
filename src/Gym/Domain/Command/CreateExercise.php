<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\Enum\MuscleTagEnum;
use Gym\Domain\Enum\StatusEnum;

class CreateExercise
{
    private StatusEnum $status;
    private int $targetRepetitions;
    private int $targetKilograms;

    public function __construct(
        StatusEnum $status,
        int $targetRepetitions,
        int $targetKilograms
    ) {
        $this->status = $status;
        $this->targetRepetitions = $targetRepetitions;
        $this->targetKilograms = $targetKilograms;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function getTargetRepetitions(): int
    {
        return $this->targetRepetitions;
    }

    public function getTargetKilograms(): int
    {
        return $this->targetKilograms;
    }
}
