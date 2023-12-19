<?php

declare(strict_types=1);

namespace Gym\Domain\ExerciseToTraining;

use Gym\Domain\Enum\StatusEnum;

class ExerciseToTrainingDTO
{
    public ?string $id = null;
    public ?string $trainingId = null;
    public ?string $exerciseId = null;
    public ?StatusEnum $status = null;
    public ?int $seriesGoal = null;
    public ?int $repetitionGoal = null;
    public ?int $kilogramGoal = null;
    public ?\DateTimeImmutable $createdAt = null;

}
