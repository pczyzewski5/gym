<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\Training\TrainingPersister;

class DeleteTrainingHandler
{
    private TrainingPersister $persister;

    public function __construct(TrainingPersister $persister)
    {
        $this->persister = $persister;
    }

    public function handle(DeleteTraining $command): void
    {
        $this->persister->delete(
            $command->getId()
        );
    }
}
