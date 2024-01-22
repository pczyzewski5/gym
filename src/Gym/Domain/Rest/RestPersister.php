<?php

declare(strict_types=1);

namespace Gym\Domain\Rest;

use Gym\Domain\Exception\PersisterException;
use Gym\Domain\Rest\Rest as DomainEntity;

interface RestPersister
{
    /**
     * @throws PersisterException
     */
    public function put(DomainEntity $domainEntity): void;
}
