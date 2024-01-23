<?php

declare(strict_types=1);

namespace Gym\Domain\Query;

use Gym\Domain\ExerciseToStation\ExerciseToStationRepository;

class GetExerciseToStationInclNamesHandler
{
    private ExerciseToStationRepository $repository;

    public function __construct(ExerciseToStationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetExerciseToStationInclNames $query): array
    {
        $result = $this->repository->findAllWithNames();

        foreach ($result as $key => $data) {
            if ($data['exercise_id'] === '8af11920-9de4-11ee-85da-0bab4c113dcc'
                && $data['station_id'] === 'abd90d32-9de4-11ee-8b09-511a5eec1e52'
            ) {
                unset($result[$key]);
                break;
            }
        }

        \array_unshift($result, $data);

        return $result;
    }
}
