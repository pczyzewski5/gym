<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\ExerciseToStation\ExerciseToStationFactory;
use Gym\Domain\ExerciseToStation\ExerciseToStationPersister;

class PutExercisesToStationHandler
{
    private ExerciseToStationPersister $persister;

    public function __construct(ExerciseToStationPersister $persister)
    {
        $this->persister = $persister;
    }

    public function handle(PutExercisesToStation $command): void
    {
        $this->persister->deleteManyByStationId($command->getStationId());

        foreach ($command->getExerciseIds() as $exerciseId) {
            $entity = ExerciseToStationFactory::create(
                $exerciseId,
                $command->getStationId(),
            );

            $this->persister->save($entity);
        }
    }
}
