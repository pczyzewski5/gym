<?php

declare(strict_types=1);

namespace Gym\Domain\Exercise;

use App\MergerTrait;
use Gym\Domain\Enum\StatusEnum;
use Symfony\Component\Uid\UuidV1;
use Gym\Domain\Exception\ValidationException;

class Exercise
{
    use MergerTrait;

    private string $id;
    private StatusEnum $status;
    private ?string $stationId = null;
    private int $repetitionTarget;
    private int $kilogramTarget;
    private \DateTimeImmutable $createdAt;

    public function __construct(ExerciseDTO $dto)
    {
        $this->merge($dto);
    }

    public function update(ExerciseDTO $dto): void
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

        if (isset($this->stationId) && false === UuidV1::isValid($this->stationId)) {
            throw ValidationException::missingProperty('stationId');
        }

        if (!isset($this->repetitionTarget)) {
            throw ValidationException::missingProperty('repetitionTarget');
        }

        if (!isset($this->kilogramTarget)) {
            throw ValidationException::missingProperty('kilogramTarget');
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

    public function getStationId(): ?string
    {
        return $this->stationId;
    }
    public function getRepetitionTarget(): int
    {
        return $this->repetitionTarget;
    }

    public function getKilogramTarget(): int
    {
        return $this->kilogramTarget;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
