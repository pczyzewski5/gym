<?php

declare(strict_types=1);

namespace Gym\Domain\Query;

use Gym\Domain\Training\TrainingRepository;

class FindTrainingsForListHandler
{
    private TrainingRepository $repository;

    public function __construct(TrainingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FindTrainingsForList $query): array
    {
        $trainings = $this->repository->findAllForList();

        $result = [];

        foreach ($trainings as $training) {
            $year = $training['training_date']->format('Y');
            $month = $training['training_date']->format('F');
            $result[$year][$month][] = $training;
        }

        return $result;
    }
}
