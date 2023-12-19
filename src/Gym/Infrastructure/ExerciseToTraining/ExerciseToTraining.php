<?php

declare(strict_types=1);

namespace Gym\Infrastructure\ExerciseToTraining;

class ExerciseToTraining
{
    public ?string $id;
    public ?string $trainingId;
    public ?string $stationId;
    public ?string $exerciseId;
    public ?string $status;
    public ?int $seriesGoal;
    public ?int $repetitionGoal;
    public ?int $kilogramGoal;
    public ?\DateTime $createdAt;
}
