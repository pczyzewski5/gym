<?php

declare(strict_types=1);

namespace Gym\Domain\Query;

use Gym\Domain\LiftedWeight\LiftedWeightRepository;

class GetLiftedKilogramsCountHandler
{
    private LiftedWeightRepository $repository;

    public function __construct(LiftedWeightRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetLiftedKilogramsCount $query): int
    {
        return $this->repository->getLiftedKilogramsCount(
            $query->getTrainingId()
        );
    }
}
