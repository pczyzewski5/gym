<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\Training\TrainingFactory;
use Gym\Domain\Training\TrainingPersister;

class CreateTrainingHandler
{
    private TrainingPersister $persister;

    public function __construct(TrainingPersister $persister)
    {
        $this->persister = $persister;
    }

    public function handle(CreateTraining $command): string
    {
        $entity = TrainingFactory::create(
            $command->getStatus(),
            $command->getDate(),
            $command->isRepeated()
        );

        $this->persister->save($entity);

        return $entity->getId();
    }
}
