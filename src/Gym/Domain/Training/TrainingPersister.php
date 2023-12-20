<?php

namespace Gym\Domain\Training;

use Gym\Domain\Enum\StatusEnum;
use Gym\Domain\Exception\PersisterException;
use Gym\Domain\Training\Training as DomainEntity;

interface TrainingPersister
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

    public function updateStatus(string $id, StatusEnum $status): void;
}
