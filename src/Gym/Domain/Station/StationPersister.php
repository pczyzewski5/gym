<?php

namespace Gym\Domain\Station;

use Gym\Domain\Exception\PersisterException;
use Gym\Domain\Station\Station as DomainEntity;

interface StationPersister
{
    /**
     * @throws PersisterException
     */
    public function save(DomainEntity $domainEntity): void;

    /**
     * @throws PersisterException
     */
    public function update(DomainEntity $domainEntity): void;

    /**
     * @throws PersisterException
     */
    public function delete(string $id): void;
}
