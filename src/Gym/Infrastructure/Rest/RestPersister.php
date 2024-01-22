<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Rest;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Gym\Domain\Rest\RestPersister as DomainPersister;
use Gym\Domain\Rest\Rest as DomainEntity;
use Gym\Domain\Exception\PersisterException;

class RestPersister implements DomainPersister
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws PersisterException
     */
    public function put(DomainEntity $domainEntity): void
    {
        $entity = RestMapper::fromDomain($domainEntity);

        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }
}
