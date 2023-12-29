<?php

declare(strict_types=1);

namespace Gym\Domain\LiftedWeight;

class MetricsHelper
{
    private LiftedWeightRepository $repository;

    private ?array $totalLiftedWeightPerTraining = null;

    public function __construct(
        LiftedWeightRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function getTotalLiftedWeightPerTraining(): string
    {
        if (null === $this->totalLiftedWeightPerTraining) {
            $this->setTotalLiftedWeightPerTraining();
        }

        return \json_encode($this->totalLiftedWeightPerTraining);
    }

    public function getAverageLiftedWeight(): int
    {
        $liftedWeight = 0;

        foreach (\json_decode($this->getTotalLiftedWeightPerTraining()) as $kilograms) {
            $liftedWeight += \intval($kilograms);
        }

        return $liftedWeight / \count($this->totalLiftedWeightPerTraining);
    }

    public function setTotalLiftedWeightPerTraining(): void
    {
        $result = [];

        foreach ($this->repository->getTotalLiftedWeightPerTraining() as $item) {
            $date = \date_format(
                \date_create($item['training_date']),
                'd-m-Y'
            );

            $result[$date] = $item['kilograms_total'];
        }

        $this->totalLiftedWeightPerTraining = $result;
    }
}
