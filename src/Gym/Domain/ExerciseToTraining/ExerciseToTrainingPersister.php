<?php

namespace Gym\Domain\ExerciseToTraining;

use Gym\Domain\Exception\PersisterException;
use Gym\Domain\ExerciseToTraining\ExerciseToTraining as DomainEntity;

interface ExerciseToTrainingPersister
{
    /**
     * @throws PersisterException
     */
    public function save(DomainEntity $domainEntity): void;

    /**
     * @throws PersisterException
     */
    public function delete(string $id): void;
}
