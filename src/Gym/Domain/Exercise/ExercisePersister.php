<?php

namespace Gym\Domain\Exercise;

use Gym\Domain\Exception\PersisterException;
use Gym\Domain\Exercise\Exercise as DomainEntity;

interface ExercisePersister
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
