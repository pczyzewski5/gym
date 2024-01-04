<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\ExerciseToStation\ExerciseToStationPersister;

class DeleteExerciseToStationHandler
{
    private ExerciseToStationPersister $persister;

    public function __construct(ExerciseToStationPersister $persister)
    {
        $this->persister = $persister;
    }

    public function handle(DeleteExerciseToStation $command): void
    {
        $this->persister->deleteManyByStationId($command->getStationId());
    }
}
