<?php

declare(strict_types=1);

namespace Gym\Domain\Query;

use Gym\Domain\ExerciseToTraining\ExerciseToTraining;
use Gym\Domain\ExerciseToTraining\ExerciseToTrainingRepository;

class GetExerciseToTrainingHandler
{
    private ExerciseToTrainingRepository $repository;

    public function __construct(ExerciseToTrainingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetExerciseToTraining $query): ExerciseToTraining
    {
        return $this->repository->getOneById(
            $query->getId()
        );
    }
}
