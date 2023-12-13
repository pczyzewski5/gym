<?php

declare(strict_types=1);

namespace Gym\Domain\Exercise;

use Gym\Domain\Enum\StatusEnum;
use Symfony\Component\Uid\Uuid;

class ExerciseFactory
{
    public static function create(
        StatusEnum $status,
        int $seriesTarget,
        int $repetitionTarget,
        int $kilogramTarget,
        ?string $stationId = null,
    ): Exercise {
        $dto = new ExerciseDTO();
        $dto->id = Uuid::v1()->toRfc4122();
        $dto->status = $status;
        $dto->stationId = $stationId;
        $dto->seriesTarget = $seriesTarget;
        $dto->repetitionTarget = $repetitionTarget;
        $dto->kilogramTarget = $kilogramTarget;
        $dto->createdAt = new \DateTimeImmutable();

        return new Exercise($dto);
    }
}
