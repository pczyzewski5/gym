<?php

declare(strict_types=1);

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
    public function deleteManyByStationId(string $stationId): void;
}
