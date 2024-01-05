<?php

declare(strict_types=1);

namespace Gym\Domain\LiftedWeight;

class MetricsHelper
{
    private array $totalLiftedWeightPerTraining;

    public function __construct(LiftedWeightRepository $repository)
    {
        $this->totalLiftedWeightPerTraining = $this->getDecoratedTotalLiftedWeightPerTraining($repository);
    }

    public function getTotalLiftedWeightPerTraining(): string
    {
        return \json_encode($this->totalLiftedWeightPerTraining);
    }

    public function getLiftedKilogramsTotal(): int
    {
        $result = 0;

        foreach ($this->totalLiftedWeightPerTraining as $data) {
            $result += \intval($data['kilograms_total']);
        }

        return $result;
    }

    public function getAverageLiftedWeight(): int
    {
        return \intval(
            $this->getLiftedKilogramsTotal() / \count($this->totalLiftedWeightPerTraining)
        );
    }

    private function getDecoratedTotalLiftedWeightPerTraining(LiftedWeightRepository $repository): array
    {
        return \array_map(function (array $item) {
            $item['training_id'] = $item['id'];
            $item['training_date'] = \date_format(\date_create($item['training_date']), 'd-m-Y');
            unset($item['id']);

            return $item;
        }, $repository->getTotalLiftedWeightPerTraining());
    }
}
