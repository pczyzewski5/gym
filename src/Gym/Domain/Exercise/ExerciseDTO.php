<?php

declare(strict_types=1);

namespace Gym\Domain\Exercise;

class ExerciseDTO
{
    public ?string $id = null;
    public ?string $name = null;
    public ?string $status = null;
    public ?string $stationId = null;
    public ?int $repetitionTarget = null;
    public ?int $kilogramTarget = null;
    public ?\DateTimeImmutable $createdAt = null;
}
