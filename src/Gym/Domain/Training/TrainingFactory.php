<?php

declare(strict_types=1);

namespace Gym\Domain\Training;

use Gym\Domain\Enum\StatusEnum;
use Symfony\Component\Uid\Uuid;

class TrainingFactory
{
    public static function create(
        StatusEnum $status,
        \DateTimeImmutable $date,
        bool $repeated
    ): Training {
        $dto = new TrainingDTO();
        $dto->id = Uuid::v1()->toRfc4122();
        $dto->status = $status;
        $dto->trainingDate = $date;
        $dto->repeated = $repeated;
        $dto->createdAt = new \DateTimeImmutable();

        return new Training($dto);
    }
}
