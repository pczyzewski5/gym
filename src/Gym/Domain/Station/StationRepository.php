<?php

declare(strict_types=1);

namespace Gym\Domain\Station;

use Gym\Domain\Station\Station as DomainEntity;
use Gym\Domain\Exception\RepositoryException;

interface StationRepository
{
    /**
     * @throws RepositoryException
     */
    public function getOneById(string $id): DomainEntity;

    /**
     * @return Station[]
     */
    public function findAll(): array;
}
