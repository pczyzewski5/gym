<?php

declare(strict_types=1);

namespace Gym\Domain\Rest;

use Gym\Domain\Rest\Rest as DomainEntity;

interface RestRepository
{
    /**
     * @return DomainEntity[]
     */
    public function findOneBy(string $stationId, string $exerciseId): array;
}
