<?php

declare(strict_types=1);

namespace Gym\Domain\Query;

use Gym\Domain\LiftedWeight\LiftedWeight;
use Gym\Domain\LiftedWeight\LiftedWeightRepository;

class GetLiftedWeightsHandler
{
    private LiftedWeightRepository $repository;

    public function __construct(LiftedWeightRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return LiftedWeight[]
     */
    public function __invoke(GetLiftedWeights $query): array
    {
        return $this->repository->findAllBy(
            $query->getTrainingId(),
            $query->getStationId(),
            $query->getExerciseId()
        );
    }
}
