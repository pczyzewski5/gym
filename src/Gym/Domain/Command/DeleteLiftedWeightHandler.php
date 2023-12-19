<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\LiftedWeight\LiftedWeightPersister;

class DeleteLiftedWeightHandler
{
    private LiftedWeightPersister $persister;

    public function __construct(LiftedWeightPersister $persister)
    {
        $this->persister = $persister;
    }

    public function handle(DeleteLiftedWeight $command): void
    {
        $this->persister->delete($command->getId()->toRfc4122());
    }
}
