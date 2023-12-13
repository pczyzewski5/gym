<?php

declare(strict_types=1);

namespace Gym\Domain\ExerciseToTraining;

use App\MergerTrait;
use Symfony\Component\Uid\UuidV1;
use Gym\Domain\Exception\ValidationException;

class ExerciseToTraining
{
    use MergerTrait;

    private string $exerciseId;
    private string $trainingId;

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
        if (!isset($this->exerciseId) && UuidV1::isValid($this->exerciseId)) {
            throw ValidationException::missingProperty('exerciseId');
        }

        if (!isset($this->trainingId) && UuidV1::isValid($this->trainingId)) {
            throw ValidationException::missingProperty('trainingId');
        }
    }

    public function getExerciseId(): string
    {
        return $this->exerciseId;
    }

    public function getTrainingId(): string
    {
        return $this->trainingId;
    }
}
