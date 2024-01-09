<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\Enum\StatusEnum;

class UpdateTraining
{
    private string $trainingToUpdateId;
    private ?StatusEnum $status;
    private ?\DateTimeImmutable $trainingDate;
    private ?\DateTimeImmutable $trainingStarted;
    private ?\DateTimeImmutable $trainingFinished;
    private ?bool $repeated;

    public function __construct(
        string $id,
        ?StatusEnum $status = null,
        ?\DateTimeImmutable $trainingDate = null,
        ?\DateTimeImmutable $trainingStarted = null,
        ?\DateTimeImmutable $trainingFinished = null,
        ?bool $repeated = null
    ) {
        $this->trainingToUpdateId = $id;
        $this->status = $status;
        $this->trainingDate = $trainingDate;
        $this->trainingStarted = $trainingStarted;
        $this->trainingFinished = $trainingFinished;
        $this->repeated = $repeated;
    }

    public function getTrainingToUpdateId(): string
    {
        return $this->trainingToUpdateId;
    }

    public function getStatus(): ?StatusEnum
    {
        return $this->status;
    }

    public function getTrainingDate(): ?\DateTimeImmutable
    {
        return $this->trainingDate;
    }

    public function getTrainingStarted(): ?\DateTimeImmutable
    {
        return $this->trainingStarted;
    }

    public function getTrainingFinished(): ?\DateTimeImmutable
    {
        return $this->trainingFinished;
    }

    public function getRepeated(): ?bool
    {
        return $this->repeated;
    }
}
