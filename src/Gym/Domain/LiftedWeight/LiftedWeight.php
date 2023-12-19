<?php

declare(strict_types=1);

namespace Gym\Domain\LiftedWeight;

use App\MergerTrait;
use Symfony\Component\Uid\UuidV1;
use Gym\Domain\Exception\ValidationException;

class LiftedWeight
{
    use MergerTrait;

    private string $id;
    private string $trainingId;
    private string $stationId;
    private string $exerciseId;
    private int $repetitionCount;
    private int $kilogramCount;
    private \DateTimeImmutable $createdAt;

    public function __construct(LiftedWeightDTO $dto)
    {
        $this->merge($dto);
    }

    public function update(LiftedWeightDTO $dto): void
    {
        $this->merge($dto);
        $this->validate();
    }

    private function validate(): void
    {
        if (!isset($this->id) || !UuidV1::isValid($this->id)) {
            throw ValidationException::missingProperty('id');
        }

        if (!isset($this->trainingId) || !UuidV1::isValid($this->trainingId)) {
            throw ValidationException::missingProperty('trainingId');
        }

        if (!isset($this->stationId) || !UuidV1::isValid($this->stationId)) {
            throw ValidationException::missingProperty('stationId');
        }

        if (!isset($this->exerciseId) || !UuidV1::isValid($this->exerciseId)) {
            throw ValidationException::missingProperty('exerciseId');
        }

        if (!isset($this->repetitionCount)) {
            throw ValidationException::missingProperty('repetitionCount');
        }

        if (!isset($this->kilogramCount)) {
            throw ValidationException::missingProperty('kilogramCount');
        }

        if (!isset($this->createdAt) || !($this->createdAt instanceof \DateTimeImmutable)) {
            throw ValidationException::missingProperty('createdAt');
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTrainingId(): string
    {
        return $this->trainingId;
    }

    public function getStationId(): string
    {
        return $this->stationId;
    }

    public function getExerciseId(): string
    {
        return $this->exerciseId;
    }

    public function getRepetitionCount(): int
    {
        return $this->repetitionCount;
    }

    public function getKilogramCount(): int
    {
        return $this->kilogramCount;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
