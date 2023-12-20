<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\Training\TrainingPersister;

class ChangeTrainingStatusHandler
{
    private TrainingPersister $persister;

    public function __construct(TrainingPersister $persister)
    {
        $this->persister = $persister;
    }

    public function handle(ChangeTrainingStatus $command): void
    {
        $this->persister->updateStatus(
            $command->getId()->toRfc4122(),
            $command->getStatus()
        );
    }
}
