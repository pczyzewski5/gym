<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Training;

use Gym\Domain\Exception\RepositoryException;
use Doctrine\ORM\EntityManagerInterface;
use Gym\Domain\Training\Training as DomainEntity;
use Gym\Domain\Training\TrainingRepository as DomainRepository;

class TrainingRepository implements DomainRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getOneById(string $id): DomainEntity
    {
        $entity = $this->entityManager->getRepository(Training::class)->getOneById($id);

        if (null === $entity) {
            throw RepositoryException::notFound(Training::class, $id);
        }

        return TrainingMapper::toDomain($entity);
    }

    /**
     * @return DomainEntity[]
     */
    public function findAll(): array
    {
        return TrainingMapper::mapArrayToDomain(
            $this->entityManager->getRepository(Training::class)->findAll()
        );
    }
}
