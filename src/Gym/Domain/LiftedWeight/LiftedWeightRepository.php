<?php

declare(strict_types=1);

namespace Gym\Domain\LiftedWeight;

use Gym\Domain\Exception\RepositoryException;
use Gym\Domain\LiftedWeight\LiftedWeight as DomainEntity;

interface LiftedWeightRepository
{
    /**
     * @return DomainEntity[]
     */
    public function findAllBy(
        string $trainingId,
        string $stationId,
        string $exerciseId
    ): array;

    /**
     * @throws RepositoryException
     */
    public function getOneById(string $id): DomainEntity;

    public function findForTrainingRead(string $trainingId): array;

    public function getLiftedKilogramsCount(string $trainingId): int;

    public function findLastLiftedWeight(string $stationId, string $exerciseId): ?DomainEntity;

    public function getAllForMetrics(): array;
}
