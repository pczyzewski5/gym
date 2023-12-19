<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Symfony\Component\Uid\AbstractUid;

class CreateLiftedWeight
{
    private AbstractUid $trainingId;
    private AbstractUid $stationId;
    private AbstractUid $exerciseId;
    private int $repetitionCount;
    private int $kilogramCount;

    public function __construct(
        AbstractUid $trainingId,
        AbstractUid $stationId,
        AbstractUid $exerciseId,
        int $repetitionCount,
        int $kilogramCount,
    ) {
        $this->trainingId = $trainingId;
        $this->stationId = $stationId;
        $this->exerciseId = $exerciseId;
        $this->repetitionCount = $repetitionCount;
        $this->kilogramCount = $kilogramCount;
    }

    public function getTrainingId(): AbstractUid
    {
        return $this->trainingId;
    }

    public function getStationId(): AbstractUid
    {
        return $this->stationId;
    }

    public function getExerciseId(): AbstractUid
    {
        return $this->exerciseId;
    }

    public function getRepetitionCount(): int
    {
        return $this->repetitionCount;
    }

    public function getKilogramCount(): int
    {
        return $this->kilogramCount;
    }
}
