<?php

declare(strict_types=1);

namespace Gym\Infrastructure\LiftedWeight;

class LiftedWeight
{
    public ?string $id;
    public ?string $trainingId;
    public ?string $stationId;
    public ?string $exerciseId;
    public ?int $repetitionCount;
    public ?int $kilogramCount;
    public ?\DateTime $createdAt;
}
