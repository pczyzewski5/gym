<?php

declare(strict_types=1);

namespace Gym\Domain\Exercise;

use App\MergerTrait;
use Symfony\Component\Uid\UuidV1;
use Gym\Domain\Exception\ValidationException;

class Exercise
{
    use MergerTrait;

    private string $id;
    private string $name;
    private string $status;
    private string $stationId;
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

        if (!isset($this->name) || '' === $this->name) {
            throw ValidationException::missingProperty('name');
        }

        if (!isset($this->status) || '' === $this->status) {
            throw ValidationException::missingProperty('status');
        }

        if (!isset($this->stationId) && UuidV1::isValid($this->stationId)) {
            throw ValidationException::missingProperty('photoId');
        }

        if (!isset($this->repetitionTarget) && \is_int($this->repetitionTarget)) {
            throw ValidationException::missingProperty('repetitionTarget');
        }

        if (!isset($this->kilogramTarget) && \is_int($this->kilogramTarget)) {
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

    public function getName(): string
    {
        return $this->name;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getStationId(): string
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
