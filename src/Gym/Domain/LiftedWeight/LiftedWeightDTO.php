<?php

declare(strict_types=1);

namespace Gym\Domain\LiftedWeight;

class LiftedWeightDTO
{
    public ?string $id = null;
    public ?string $trainingId = null;
    public ?string $stationId = null;
    public ?string $exerciseId = null;
    public ?int $repetitionCount = null;
    public ?int $kilogramCount = null;
    public ?\DateTimeImmutable $createdAt = null;

}
