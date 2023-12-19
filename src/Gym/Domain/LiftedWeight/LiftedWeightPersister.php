<?php

namespace Gym\Domain\LiftedWeight;

use Gym\Domain\Enum\LiftedWeightOwnerEnum;
use Gym\Domain\Exception\PersisterException;
use Gym\Domain\LiftedWeight\LiftedWeight as DomainEntity;

interface LiftedWeightPersister
{
    /**
     * @throws PersisterException
     */
    public function save(DomainEntity $domainEntity): void;
}