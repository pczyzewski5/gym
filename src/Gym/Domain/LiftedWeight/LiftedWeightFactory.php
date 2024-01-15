<?php

declare(strict_types=1);

namespace Gym\Domain\LiftedWeight;

use Symfony\Component\Uid\Uuid;

class LiftedWeightFactory
{
    public static function create(
        string $trainingId,
        string $stationId,
        string $exerciseId,
        int $repetitionCount,
        int $kilogramCount,
    ): LiftedWeight {
        $dto = new LiftedWeightDTO();
        $dto->id = Uuid::v1()->toRfc4122();
        $dto->trainingId = $trainingId;
        $dto->stationId = $stationId;
        $dto->exerciseId = $exerciseId;
        $dto->repetitionCount = $repetitionCount;
        $dto->kilogramCount = $kilogramCount;
        $dto->createdAt = new \DateTimeImmutable();

        return new LiftedWeight($dto);
    }
}
