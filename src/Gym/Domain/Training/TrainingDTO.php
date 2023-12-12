<?php

declare(strict_types=1);

namespace Gym\Domain\Training;

class TrainingDTO
{
    public ?string $id = null;
    public ?string $status = null;
    public ?\DateTimeImmutable $date = null;
    public ?\DateTimeImmutable $createdAt = null;
}
