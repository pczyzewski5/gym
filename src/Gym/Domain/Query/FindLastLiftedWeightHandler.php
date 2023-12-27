<?php

declare(strict_types=1);

namespace Gym\Domain\Query;

use Gym\Domain\LiftedWeight\LiftedWeight;
use Gym\Domain\LiftedWeight\LiftedWeightRepository;

class FindLastLiftedWeightHandler
{
    private LiftedWeightRepository $repository;

    public function __construct(LiftedWeightRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FindLastLiftedWeight $query): ?LiftedWeight
    {
        return $this->repository->findLastLiftedWeight(
            $query->getStationId(),
            $query->getExerciseId()
        );
    }
}
