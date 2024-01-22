<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Rest;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Gym\Domain\Rest\RestRepository as DomainRepository;

class RestRepository implements DomainRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findOneBy(string $stationId, string $exerciseId): array
    {
        // TODO: Implement findBy() method.
    }
}
