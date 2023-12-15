<?php

namespace Gym\Domain\ExerciseToStation;

use Gym\Domain\Exception\PersisterException;
use Gym\Domain\ExerciseToStation\ExerciseToStation as DomainEntity;

interface ExerciseToStationPersister
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
