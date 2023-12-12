<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\Exercise\ExerciseFactory;
use Gym\Domain\Exercise\ExercisePersister;
use Gym\Domain\Station\StationFactory;
use Gym\Domain\Station\StationPersister;

class CreateStationHandler
{
    private StationPersister $persister;

    public function __construct(StationPersister $persister)
    {
        $this->persister = $persister;
    }

    public function handle(CreateStation $command): string
    {
        $entity = StationFactory::create(
            $command->getName(),
            $command->getPhoto(),
        );

        $this->persister->save($entity);

        return $entity->getId();
    }
}
