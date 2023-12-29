<?php

declare(strict_types=1);

namespace Gym\Domain\Query;

use Gym\Domain\LiftedWeight\LiftedWeightRepository;
use Gym\Domain\LiftedWeight\MetricsHelper;

class GetMetricsHelperHandler
{
    private LiftedWeightRepository $liftedWeightRepository;

    public function __construct(LiftedWeightRepository $liftedWeightRepository)
    {
        $this->liftedWeightRepository = $liftedWeightRepository;
    }

    public function __invoke(GetMetricsHelper $query): MetricsHelper
    {
        return new MetricsHelper(
            $this->liftedWeightRepository
        );
    }
}
