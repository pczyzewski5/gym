<?php

declare(strict_types=1);

namespace Gym\Domain\LiftedWeight;

use Gym\Domain\Exception\RepositoryException;
use Gym\Domain\LiftedWeight\LiftedWeight as DomainEntity;

interface LiftedWeightRepository
{
    /**
     * @throws RepositoryException
     */
    public function getOneById(string $id): DomainEntity;
}
