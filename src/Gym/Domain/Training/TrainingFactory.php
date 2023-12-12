<?php

declare(strict_types=1);

namespace Gym\Domain\Training;

class TrainingFactory
{
    public static function create(
        string $id,
        string $status,
        \DateTimeImmutable $date,
    ): Training {
        $dto = new TrainingDTO();
        $dto->id = $id;
        $dto->status = $status;
        $dto->date = $date;
        $dto->createdAt = new \DateTimeImmutable();

        return new Training($dto);
    }
}
