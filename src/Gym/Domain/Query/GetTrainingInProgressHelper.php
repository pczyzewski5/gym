<?php

declare(strict_types=1);

namespace Gym\Domain\Query;

class GetTrainingInProgressHelper
{
    private string $trainingId;

    public function __construct(string $trainingId)
    {
        $this->trainingId = $trainingId;
    }

    public function getTrainingId(): string
    {
        return $this->trainingId;
    }
}
