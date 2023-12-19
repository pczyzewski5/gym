<?php

declare(strict_types=1);

namespace Gym\Domain\ExerciseToTraining;

use Gym\Domain\Exception\RepositoryException;
use Gym\Domain\ExerciseToTraining\ExerciseToTraining as DomainEntity;

interface ExerciseToTrainingRepository
{
    /**
     * @throws RepositoryException
     */
    public function getOneById(string $id): DomainEntity;
}
