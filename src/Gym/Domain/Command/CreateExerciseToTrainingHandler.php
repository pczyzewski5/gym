<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\ExerciseToTraining\ExerciseToTrainingFactory;
use Gym\Domain\ExerciseToTraining\ExerciseToTrainingPersister;

class CreateExerciseToTrainingHandler
{
    private ExerciseToTrainingPersister $persister;

    public function __construct(ExerciseToTrainingPersister $persister)
    {
        $this->persister = $persister;
    }

    public function handle(CreateExerciseToTraining $command): void
    {
        $entity = ExerciseToTrainingFactory::create(
          $command->getExerciseId(),
          $command->getTrainingId(),
        );

        $this->persister->save($entity);
    }
}
