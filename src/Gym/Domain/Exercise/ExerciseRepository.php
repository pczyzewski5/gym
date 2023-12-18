<?php

declare(strict_types=1);

namespace Gym\Domain\Exercise;

use Gym\Domain\Enum\MuscleTagEnum;
use Gym\Domain\Exercise\Exercise as DomainEntity;
use Gym\Domain\Exception\RepositoryException;
use Gym\Domain\Station\Station;

interface ExerciseRepository
{
    /**
     * @throws RepositoryException
     */
    public function getOneById(string $id): DomainEntity;

    /**
     * @return Exercise[]
     */
    public function findAll(): array;

    /**
     * @return Exercise[]
     */
    public function findAllByStationAndTag(Station $station, MuscleTagEnum $tagEnum): array;

    public function findAllForList(): array;
}
