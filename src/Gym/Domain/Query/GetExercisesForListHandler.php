<?php

declare(strict_types=1);

namespace Gym\Domain\Query;

use Gym\Domain\Exercise\ExerciseRepository;

class GetExercisesForListHandler
{
    private ExerciseRepository $repository;

    public function __construct(ExerciseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetExercisesForList $query): array
    {
        $exercises = $this->repository->findAllForList();
        \usort($exercises, function (array $exerciseA, array $exerciseB) {
            return strcmp($exerciseA['name'], $exerciseB['name']);
        });

        $result = [];

        foreach ($exercises as $exercise) {
            $result[$exercise['tag']][] = $exercise;
        }

        return $result;
    }
}
