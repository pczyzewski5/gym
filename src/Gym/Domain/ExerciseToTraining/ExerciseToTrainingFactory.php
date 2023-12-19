<?php

declare(strict_types=1);

namespace Gym\Domain\ExerciseToTraining;

use Gym\Domain\Enum\StatusEnum;
use Symfony\Component\Uid\Uuid;

class ExerciseToTrainingFactory
{
    public static function create(
        string $trainingId,
        string $stationId,
        string $exerciseId,
        StatusEnum $status,
        int $seriesGoal,
        int $repetitionGoal,
        int $kilogramGoal,
    ): ExerciseToTraining {
        $dto = new ExerciseToTrainingDTO();
        $dto->id = Uuid::v1()->toRfc4122();
        $dto->trainingId = $trainingId;
        $dto->stationId = $stationId;
        $dto->exerciseId = $exerciseId;
        $dto->status = $status;
        $dto->seriesGoal = $seriesGoal;
        $dto->repetitionGoal = $repetitionGoal;
        $dto->kilogramGoal = $kilogramGoal;
        $dto->createdAt = new \DateTimeImmutable();

        return new ExerciseToTraining($dto);
    }
}
