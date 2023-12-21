<?php

declare(strict_types=1);

namespace Gym\Domain\Training;

use Gym\Domain\Enum\StatusEnum;

class TrainingDTO
{
    public ?string $id = null;
    public ?StatusEnum $status = null;
    public ?\DateTimeImmutable $trainingDate = null;
    public ?\DateTimeImmutable $trainingStarted = null;
    public ?\DateTimeImmutable $trainingFinished = null;
    public ?bool $repeated = null;
    public ?\DateTimeImmutable $createdAt = null;
}
