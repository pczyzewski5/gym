<?php

declare(strict_types=1);

namespace Gym\Domain\Training;

use Gym\Domain\Training\Training as DomainEntity;
use Gym\Domain\Exception\RepositoryException;

interface TrainingRepository
{
    /**
     * @throws RepositoryException
     */
    public function getOneById(string $id): DomainEntity;

    /**
     * @return Training[]
     */
    public function findAll(): array;

    public function findAllForList(): array;

    public function findTrainingInProgress(): ?DomainEntity;
}
