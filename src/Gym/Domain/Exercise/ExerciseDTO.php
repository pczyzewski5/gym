<?php

declare(strict_types=1);

namespace Gym\Domain\Exercise;

use Gym\Domain\Enum\StatusEnum;

class ExerciseDTO
{
    public ?string $id = null;
    public ?StatusEnum $status = null;
    public ?string $stationId = null;
    public ?int $repetitionTarget = null;
    public ?int $kilogramTarget = null;
    public ?\DateTimeImmutable $createdAt = null;
}
