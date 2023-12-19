<?php

declare(strict_types=1);

namespace Gym\Domain\Query;

use Gym\Domain\Exercise\Exercise;
use Gym\Domain\Exercise\ExerciseRepository;

class GetExerciseHandler
{
    private ExerciseRepository $repository;

    public function __construct(ExerciseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetExercise $query): Exercise
    {
        return $this->repository->getOneById(
            $query->getId()
        );
    }
}
