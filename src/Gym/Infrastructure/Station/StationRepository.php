<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Station;

use Gym\Domain\Exception\RepositoryException;
use Doctrine\ORM\EntityManagerInterface;
use Gym\Domain\Station\Station as DomainEntity;
use Gym\Domain\Station\StationRepository as DomainRepository;

class StationRepository implements DomainRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getOneById(string $id): DomainEntity
    {
        $entity = $this->entityManager->getRepository(Station::class)->getOneById($id);

        if (null === $entity) {
            throw RepositoryException::notFound(Station::class, $id);
        }

        return StationMapper::toDomain($entity);
    }

    /**
     * @return DomainEntity[]
     */
    public function findAll(): array
    {
        return StationMapper::mapArrayToDomain(
            $this->entityManager->getRepository(Station::class)->findAll()
        );
    }
}
