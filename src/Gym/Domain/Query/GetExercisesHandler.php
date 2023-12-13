<?php

declare(strict_types=1);

namespace Gym\Domain\Query;

use Gym\Domain\Exercise\ExerciseRepository;

class GetExercisesHandler
{
    private ExerciseRepository $repository;

    public function __construct(ExerciseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetExercises $query): array
    {
        return $this->repository->findAllForList();
    }
}
