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
        $result = $this->filterDataWithoutTrainingId($result);
        $result = $this->filterDataWithOnlyOneTraining($result);

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

    public function filterDataWithoutTrainingId($data): array
    {
        return \array_filter($data, function(array $datum) {
            return $datum['training_id'] !== null;
        });
    }

    private function filterDataWithOnlyOneTraining(array $data): array
    {
        $exercisesToTrainings = [];

        foreach ($data as $datum) {
            $key = \implode('|', [$datum['exercise_id'], $datum['station_id']]);
            $exercisesToTrainings[$key][] = $datum['training_id'];
        }

        $exercisesTrainingsCount = [];
        foreach ($exercisesToTrainings as $key => $trainingIds) {
            $exercisesTrainingsCount[$key] = \count(
                \array_unique($trainingIds)
            );
        }

        $result = [];

        foreach ($data as $datum) {
            $key = \implode('|', [$datum['exercise_id'], $datum['station_id']]);

            if ($exercisesTrainingsCount[$key] < 2) {
                continue;
            }

            $result[$key] = $datum;
        }

      return \array_values($result);
    }
}
