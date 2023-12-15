<?php

declare(strict_types=1);

namespace Gym\Domain\ExerciseToStation;

use App\MergerTrait;
use Symfony\Component\Uid\UuidV1;
use Gym\Domain\Exception\ValidationException;

class ExerciseToStation
{
    use MergerTrait;

    private string $exerciseId;
    private string $stationId;

    public function __construct(ExerciseToStationDTO $dto)
    {
        $this->merge($dto);
    }

    public function update(ExerciseToStationDTO $dto): void
    {
        $this->merge($dto);
        $this->validate();
    }

    private function validate(): void
    {
        if (isset($this->exerciseId) && false === UuidV1::isValid($this->exerciseId)) {
            throw ValidationException::missingProperty('exerciseId');
        }

        if (isset($this->stationId) && false === UuidV1::isValid($this->stationId)) {
            throw ValidationException::missingProperty('stationId');
        }
    }

    public function getExerciseId(): string
    {
        return $this->exerciseId;
    }

    public function getStationId(): string
    {
        return $this->stationId;
    }
}
