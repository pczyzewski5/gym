<?php

declare(strict_types=1);

namespace Gym\Infrastructure\LiftedWeight;

use Doctrine\ORM\EntityManagerInterface;
use Gym\Domain\LiftedWeight\LiftedWeightPersister as DomainPersister;
use Gym\Domain\LiftedWeight\LiftedWeight as DomainEntity;
use Gym\Domain\Exception\PersisterException;

class LiftedWeightPersister implements DomainPersister
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws PersisterException
     */
    public function save(DomainEntity $domainEntity): void
    {
        $entity = LiftedWeightMapper::fromDomain($domainEntity);

        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }
}
