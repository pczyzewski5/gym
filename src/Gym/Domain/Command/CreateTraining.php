<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\Enum\TrainingStatusEnum;

class CreateTraining
{
    private TrainingStatusEnum $status;
    private \DateTimeImmutable $date;

    public function __construct(
        TrainingStatusEnum $status,
        \DateTimeImmutable $date,
    ) {
        $this->status = $status;
        $this->date = $date;
    }

    public function getStatus(): TrainingStatusEnum
    {
        return $this->status;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }
}
