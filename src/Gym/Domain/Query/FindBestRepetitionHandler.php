<?php

declare(strict_types=1);

namespace Gym\Domain\Query;

use Gym\Domain\LiftedWeight\LiftedWeightRepository;

class FindBestRepetitionHandler
{
    private LiftedWeightRepository $repository;

    public function __construct(LiftedWeightRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FindBestRepetition $query): ?array
    {
        return $this->repository->findBestRepetition(
            $query->getStationId(),
            $query->getExerciseId()
        );
    }
}
