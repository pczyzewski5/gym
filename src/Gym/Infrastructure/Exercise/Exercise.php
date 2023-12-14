<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Exercise;

class Exercise
{
    public ?string $id;
    public ?string $status;
    public ?string $stationId;
    public ?int $seriesTarget;
    public ?int $repetitionTarget;
    public ?\DateTime $createdAt;
}
