<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

class CreateExerciseToTraining
{
    private string $exerciseId;
    private string $trainingId;

    public function __construct(string $exerciseId, string $trainingId)
    {
        $this->exerciseId = $exerciseId;
        $this->trainingId = $trainingId;
    }

    public function getExerciseId(): string
    {
        return $this->exerciseId;
    }

    public function getTrainingId(): string
    {
        return $this->trainingId;
    }
}
