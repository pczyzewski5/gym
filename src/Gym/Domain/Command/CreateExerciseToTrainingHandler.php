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

    public function handle(CreateExerciseToTraining $command): string
    {
        $entity = ExerciseToTrainingFactory::create(
            $command->getTrainingId(),
            $command->getStationId(),
            $command->getExerciseId(),
            $command->getStatus(),
            $command->getSeriesGoal(),
            $command->getRepetitionGoal(),
            $command->getKilogramGoal()
        );

        $this->persister->save($entity);

        return $entity->getId();
    }
}
