<?php

declare(strict_types=1);

namespace Gym\Domain\Exercise;

use Gym\Domain\Exercise\Exercise as DomainEntity;
use Gym\Domain\Exception\RepositoryException;

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

    public function findAllForList(): array;
}
