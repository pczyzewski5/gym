<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Training;

class Training
{
    public ?string $id;
    public ?string $status;
    public ?\DateTime $trainingDate;
    public ?\DateTime $trainingStarted;
    public ?\DateTime $trainingFinished;
    public ?bool $repeated;
    public ?\DateTime $createdAt;
}
