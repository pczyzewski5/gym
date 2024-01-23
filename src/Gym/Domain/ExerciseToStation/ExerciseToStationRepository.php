<?php

declare(strict_types=1);

namespace Gym\Domain\ExerciseToStation;

interface ExerciseToStationRepository
{
    public function findAllWithNames(): array;
}
