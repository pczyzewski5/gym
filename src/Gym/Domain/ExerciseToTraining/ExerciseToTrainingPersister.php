<?php

namespace Gym\Domain\ExerciseToTraining;

use Gym\Domain\Enum\ExerciseToTrainingOwnerEnum;
use Gym\Domain\Exception\PersisterException;
use Gym\Domain\ExerciseToTraining\ExerciseToTraining as DomainEntity;

interface ExerciseToTrainingPersister
{
    /**
     * @throws PersisterException
     */
    public function save(DomainEntity $domainEntity): void;
}