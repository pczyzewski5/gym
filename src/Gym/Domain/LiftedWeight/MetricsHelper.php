<?php

declare(strict_types=1);

namespace Gym\Domain\LiftedWeight;

use App\TimeHelper;

class MetricsHelper
{
    private array $trainings;

    public function __construct(LiftedWeightRepository $repository)
    {
        $this->trainings = $this->normalize(
            $repository->getAllForMetrics()
        );
    }

    public function getTotalLiftedWeightPerTraining(): string
    {
        $trainings = \array_map(function (array $item) {
            $item['training_date'] = $item['training_date']->format('Y-m-d');
            $item['kilograms_total'] = \intval($item['kilograms_total']);

            return $item;
        }, $this->trainings);

        return \json_encode($trainings);
    }

    public function getTimeSpentOnGymPerTrainingInMinutes(): string
    {
        $trainings = \array_map(function (array $item) {
            $item['training_date'] = $item['training_date']->format('Y-m-d');
            $item['minutes_spent'] = TimeHelper::calculateDiffInMinutes(
                $item['training_finished'],
                $item['training_started']
            );

            return $item;
        }, $this->trainings);

        return \json_encode($trainings);
    }

    public function getLiftedKilogramsTotal(): int
    {
        $result = 0;

        foreach ($this->trainings as $data) {
            $result += $data['kilograms_total'];
        }

        return $result;
    }

    public function getAverageLiftedWeight(): int
    {
        return \intval(
            $this->getLiftedKilogramsTotal() / \count($this->trainings)
        );
    }

    public function getAverageTimeSpentOnGymInMinutes(): int
    {
        $minutesTotal = 0;

        foreach ($this->trainings as $data) {
            $minutesTotal += TimeHelper::calculateDiffInMinutes($data['training_finished'], $data['training_started']);
        }

        return \intval($minutesTotal / \count($this->trainings));
    }

    private function normalize(array $trainings): array
    {
        return \array_map(function (array $item) {
            $item['kilograms_total'] = \intval($item['kilograms_total']);
            $item['training_date'] = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $item['training_date']);
            $item['training_started'] = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $item['training_started']);
            $item['training_finished'] = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $item['training_finished']);

            return $item;
        }, $trainings);
    }
}
