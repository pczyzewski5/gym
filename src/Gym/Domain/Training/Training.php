<?php

declare(strict_types=1);

namespace Gym\Domain\Training;

use App\MergerTrait;
use Gym\Domain\Enum\StatusEnum;
use Symfony\Component\Uid\UuidV1;
use Gym\Domain\Exception\ValidationException;

class Training
{
    use MergerTrait;

    private string $id;
    private StatusEnum $status;
    private \DateTimeImmutable $trainingDate;
    private ?\DateTimeImmutable $trainingStarted = null;
    private ?\DateTimeImmutable $trainingFinished = null;
    private bool $repeated;
    private \DateTimeImmutable $createdAt;

    public function __construct(TrainingDTO $dto)
    {
        $this->merge($dto);
    }

    public function update(TrainingDTO $dto): void
    {
        $this->merge($dto);
        $this->validate();
    }

    private function validate(): void
    {
        if (!isset($this->id) && UuidV1::isValid($this->id)) {
            throw ValidationException::missingProperty('id');
        }

        if (!isset($this->status)) {
            throw ValidationException::missingProperty('status');
        }

        if (!isset($this->trainingDate)) {
            throw ValidationException::missingProperty('trainingDate');
        }

        if (!isset($this->repeated)) {
            throw ValidationException::missingProperty('repeated');
        }

        if (!isset($this->createdAt)) {
            throw ValidationException::missingProperty('createdAt');
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function getTrainingDate(): \DateTimeImmutable
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

    public function isRepeated(): bool
    {
        return $this->repeated;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
