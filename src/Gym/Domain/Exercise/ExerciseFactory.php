<?php

declare(strict_types=1);

namespace Gym\Domain\Exercise;

class ExerciseFactory
{
    public static function create(
        string $id,
        string $name,
        string $status,
        string $stationId,
        int $repetitionTarget,
        int $kilogramTarget,
    ): Exercise {
        $dto = new ExerciseDTO();
        $dto->id = $id;
        $dto->name = $name;
        $dto->status = $status;
        $dto->stationId = $stationId;
        $dto->repetitionTarget = $repetitionTarget;
        $dto->kilogramTarget = $kilogramTarget;
        $dto->createdAt = new \DateTimeImmutable();

        return new Exercise($dto);
    }
}
