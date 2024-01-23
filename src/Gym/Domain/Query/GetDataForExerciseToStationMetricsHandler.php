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
        $liftedWeights = $this->repository->findAllByExerciseIdAndStationId(
            $query->getExerciseId(),
            $query->getStationId()
        );

        $kilogramsToDate = [];

        /** @var LiftedWeight $liftedWeight */
        foreach ($liftedWeights as $liftedWeight) {
            $kilogramsToDate[$liftedWeight->getCreatedAt()->format('d M')][]
                = $liftedWeight->getKilogramCount();
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
