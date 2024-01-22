<?php

declare(strict_types=1);

namespace Gym\Domain\Rest;

use App\MergerTrait;
use Symfony\Component\Uid\UuidV1;
use Gym\Domain\Exception\ValidationException;

class Rest
{
    use MergerTrait;

    private string $stationId;
    private string $exerciseId;
    private int $rest;

    public function __construct(RestDTO $dto)
    {
        $this->merge($dto);
    }

    public function update(RestDTO $dto): void
    {
        $this->merge($dto);
        $this->validate();
    }

    private function validate(): void
    {
        if (!isset($this->stationId) || !UuidV1::isValid($this->stationId)) {
            throw ValidationException::missingProperty('stationId');
        }

        if (!isset($this->exerciseId) || !UuidV1::isValid($this->exerciseId)) {
            throw ValidationException::missingProperty('exerciseId');
        }

        if (!isset($this->rest)) {
            throw ValidationException::missingProperty('rest');
        }
    }

    public function getStationId(): string
    {
        return $this->stationId;
    }

    public function getExerciseId(): string
    {
        return $this->exerciseId;
    }

    public function getRest(): int
    {
        return $this->rest;
    }
}
