<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\Station\StationPersister;

class DeleteStationHandler
{
    private StationPersister $persister;

    public function __construct(StationPersister $persister)
    {
        $this->persister = $persister;
    }

    public function handle(DeleteStation $command): void
    {
        $this->persister->delete($command->getId());
    }
}
