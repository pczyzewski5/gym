<?php

declare(strict_types=1);

namespace Gym\Infrastructure\LiftedWeight;

use Doctrine\ORM\EntityManagerInterface;
use Gym\Domain\Exception\RepositoryException;
use Gym\Domain\LiftedWeight\LiftedWeightRepository as DomainRepository;
use Gym\Domain\LiftedWeight\LiftedWeight as DomainEntity;

class LiftedWeightRepository implements DomainRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getOneById(string $id): DomainEntity
    {
        $entity = $this->entityManager->getRepository(LiftedWeight::class)->find($id);

        if (null === $entity) {
            throw RepositoryException::notFound(LiftedWeight::class, $id);
        }

        return LiftedWeightMapper::toDomain($entity);
    }
}
