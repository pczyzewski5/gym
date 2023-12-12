<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Exercise;

use Gym\Domain\Exception\RepositoryException;
use Doctrine\ORM\EntityManagerInterface;
use Gym\Domain\Exercise\Exercise as DomainEntity;
use Gym\Domain\Exercise\ExerciseRepository as DomainRepository;

class ExerciseRepository implements DomainRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getOneById(string $id): DomainEntity
    {
        $entity = $this->entityManager->getRepository(Exercise::class)->getOneById($id);

        if (null === $entity) {
            throw RepositoryException::notFound(Exercise::class, $id);
        }

        return ExerciseMapper::toDomain($entity);
    }

    /**
     * @return DomainEntity[]
     */
    public function findAll(): array
    {
        return ExerciseMapper::mapArrayToDomain(
            $this->entityManager->getRepository(Exercise::class)->findAll()
        );
    }
}
