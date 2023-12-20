<?php

declare(strict_types=1);

namespace Gym\Domain\Query;

use Gym\Domain\LiftedWeight\LiftedWeightRepository;

class GetLiftedWeightsForTrainingReadHandler
{
    private LiftedWeightRepository $repository;

    public function __construct(LiftedWeightRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetLiftedWeightsForTrainingRead $query): array
    {
        return $this->repository->findForTrainingRead(
            $query->getTrainingId()
        );
    }
}
