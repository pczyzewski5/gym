<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\Exercise\ExercisePersister;

class DeleteExerciseHandler
{
    private ExercisePersister $persister;

    public function __construct(ExercisePersister $persister)
    {
        $this->persister = $persister;
    }

    public function handle(DeleteExercise $command): void
    {
        $this->persister->delete($command->getId());
    }
}
