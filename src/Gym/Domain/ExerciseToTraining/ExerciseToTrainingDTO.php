<?php

declare(strict_types=1);

namespace Gym\Domain\ExerciseToTraining;

use Gym\Domain\Enum\StatusEnum;

class ExerciseToTrainingDTO
{
    public ?string $exerciseId = null;
    public ?string $trainingId = null;
}
