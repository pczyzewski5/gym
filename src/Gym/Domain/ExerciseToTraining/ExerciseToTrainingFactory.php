<?php

declare(strict_types=1);

namespace Gym\Domain\ExerciseToTraining;

class ExerciseToTrainingFactory
{
    public static function create(
        string $exerciseId,
        string $trainingId
    ): ExerciseToTraining {
        $dto = new ExerciseToTrainingDTO();
        $dto->exerciseId = $exerciseId;
        $dto->trainingId = $trainingId;

        return new ExerciseToTraining($dto);
    }
}
