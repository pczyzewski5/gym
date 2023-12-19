<?php

declare(strict_types=1);

namespace Gym\Domain\ExerciseToTraining;

use App\MergerTrait;
use Gym\Domain\Enum\StatusEnum;
use Symfony\Component\Uid\UuidV1;
use Gym\Domain\Exception\ValidationException;

class ExerciseToTraining
{
    use MergerTrait;

    private string $id;
    private string $trainingId;
    private string $stationId;
    private string $exerciseId;
    private StatusEnum $status;
    private int $seriesGoal;
    private int $repetitionGoal;
    private int $kilogramGoal;
    private \DateTimeImmutable $createdAt;

    public function __construct(ExerciseToTrainingDTO $dto)
    {
        $this->merge($dto);
    }

    public function update(ExerciseToTrainingDTO $dto): void
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

        if (!isset($this->status) || !StatusEnum::isValid($this->status)) {
            throw ValidationException::missingProperty('status');
        }

        if (!isset($this->seriesGoal)) {
            throw ValidationException::missingProperty('seriesGoal');
        }

        if (!isset($this->repetitionGoal)) {
            throw ValidationException::missingProperty('repetitionGoal');
        }

        if (!isset($this->kilogramGoal)) {
            throw ValidationException::missingProperty('kilogramGoal');
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

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function getSeriesGoal(): int
    {
        return $this->seriesGoal;
    }

    public function getRepetitionGoal(): int
    {
        return $this->repetitionGoal;
    }

    public function getKilogramGoal(): int
    {
        return $this->kilogramGoal;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
