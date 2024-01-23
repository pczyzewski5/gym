<?php

declare(strict_types=1);

namespace Gym\Domain\Query;

use Gym\Domain\LiftedWeight\LiftedWeight;
use Gym\Domain\LiftedWeight\LiftedWeightRepository;

class GetDataForExerciseToStationMetricsHandler
{
    private LiftedWeightRepository $repository;

    public function __construct(LiftedWeightRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetDataForExerciseToStationMetrics $query): array
    {
        $data = $this->repository->findDataByExerciseIdAndStationId(
            $query->getExerciseId(),
            $query->getStationId()
        );

        $kilogramsToDate = [];

        /** @var LiftedWeight $datum */
        foreach ($data as $datum) {
            $date = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $datum['training_date']);
            $kilogramsToDate[$date->format('d M')][]
                = $datum['kilogram_count'];
        }

        $result = [];

        foreach ($kilogramsToDate as $date => $kilograms) {
            $result[] = [
                'training_date' => $date,
                'max_kilograms' => \max($kilograms)
            ];
        }

        return $result;
    }
}
