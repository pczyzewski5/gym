<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Exercise;

class Exercise
{
    public ?string $id;
    public ?string $name;
    public ?string $status;
    public ?string $stationId;
    public ?int $repetitionTarget;
    public ?int $kilogramTarget;
    public ?\DateTime $createdAt;
}
