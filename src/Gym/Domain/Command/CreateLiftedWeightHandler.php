<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\LiftedWeight\LiftedWeightFactory;
use Gym\Domain\LiftedWeight\LiftedWeightPersister;

class CreateLiftedWeightHandler
{
    private LiftedWeightPersister $persister;

    public function __construct(LiftedWeightPersister $persister)
    {
        $this->persister = $persister;
    }

    public function handle(CreateLiftedWeight $command): string
    {
        $entity = LiftedWeightFactory::create(
            $command->getTrainingId()->toRfc4122(),
            $command->getStationId()->toRfc4122(),
            $command->getExerciseId()->toRfc4122(),
            $command->getRepetitionCount(),
            $command->getKilogramCount(),
        );

        $this->persister->save($entity);

        return $entity->getId();
    }
}
