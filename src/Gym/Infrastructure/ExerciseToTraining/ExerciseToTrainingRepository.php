<?php

declare(strict_types=1);

namespace Gym\Infrastructure\ExerciseToTraining;

use Doctrine\ORM\EntityManagerInterface;
use Gym\Domain\Exception\RepositoryException;
use Gym\Domain\ExerciseToTraining\ExerciseToTrainingRepository as DomainRepository;
use Gym\Domain\ExerciseToTraining\ExerciseToTraining as DomainEntity;

class ExerciseToTrainingRepository implements DomainRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getOneById(string $id): DomainEntity
    {
        $entity = $this->entityManager->getRepository(ExerciseToTraining::class)->find($id);

        if (null === $entity) {
            throw RepositoryException::notFound(ExerciseToTraining::class, $id);
        }

        return ExerciseToTrainingMapper::toDomain($entity);
    }
}
