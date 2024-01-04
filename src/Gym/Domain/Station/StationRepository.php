<?php

declare(strict_types=1);

namespace Gym\Domain\Station;

use Gym\Domain\Enum\MuscleTagEnum;
use Gym\Domain\Exception\RepositoryException;
use Gym\Domain\Station\Station as DomainEntity;

interface StationRepository
{
    /**
     * @throws RepositoryException
     */
    public function getOneById(string $id): DomainEntity;

    public function findAllForList(): array;

    /**
     * @return Station[]
     */
    public function findAllByTag(MuscleTagEnum $tagEnum): array;

    public function findOneForRead(string $id): array;
}
