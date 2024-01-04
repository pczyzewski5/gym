<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\Exercise\ExerciseDTO;
use Gym\Domain\Exercise\ExercisePersister;
use Gym\Domain\Exercise\ExerciseRepository;

class UpdateExerciseHandler
{
    private ExerciseRepository $repository;
    private ExercisePersister $persister;

    public function __construct(ExerciseRepository $repository, ExercisePersister $persister)
    {
        $this->repository = $repository;
        $this->persister = $persister;
    }

    public function handle(UpdateExercise $command): string
    {
        $entity = $this->repository->getOneById(
            $command->getId()
        );

        $dto = new ExerciseDTO();
        $dto->name = $command->getName();
        $dto->description = $command->getDescription();
        $dto->image = $command->getImage();

        $entity->update($dto);

        $this->persister->update($entity);

        return $entity->getId();
    }
}
