<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\Enum\StatusEnum;

class CreateTraining
{
    private StatusEnum $status;
    private \DateTimeImmutable $date;
    private bool $repeated;

    public function __construct(
        StatusEnum $status,
        \DateTimeImmutable $date,
        bool $repeated
    ) {
        $this->status = $status;
        $this->date = $date;
        $this->repeated = $repeated;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function isRepeated(): bool
    {
        return $this->repeated;
    }
}
