<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\Exercise\ExerciseFactory;
use Gym\Domain\Exercise\ExercisePersister;

class CreateExerciseHandler
{
    private ExercisePersister $persister;

    public function __construct(ExercisePersister $persister)
    {
        $this->persister = $persister;
    }

    public function handle(CreateExercise $command): string
    {
        $entity = ExerciseFactory::create(
            $command->getName(),
            $command->getDescription(),
            $command->getSeparateLoad(),
            $command->getImage()
        );

        $this->persister->save($entity);

        return $entity->getId();
    }
}
