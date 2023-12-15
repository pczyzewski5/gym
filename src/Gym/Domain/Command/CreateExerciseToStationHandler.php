<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\ExerciseToStation\ExerciseToStationFactory;
use Gym\Domain\ExerciseToStation\ExerciseToStationPersister;

class CreateExerciseToStationHandler
{
    private ExerciseToStationPersister $persister;

    public function __construct(ExerciseToStationPersister $persister)
    {
        $this->persister = $persister;
    }

    public function handle(CreateExerciseToStation $command): void
    {
        $entity = ExerciseToStationFactory::create(
          $command->getExerciseId(),
          $command->getStationId(),
        );

        $this->persister->save($entity);
    }
}
