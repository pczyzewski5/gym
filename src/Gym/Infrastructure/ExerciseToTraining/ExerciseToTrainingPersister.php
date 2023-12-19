<?php

declare(strict_types=1);

namespace Gym\Infrastructure\ExerciseToTraining;

use Doctrine\ORM\EntityManagerInterface;
use Gym\Domain\ExerciseToTraining\ExerciseToTrainingPersister as DomainPersister;
use Gym\Domain\ExerciseToTraining\ExerciseToTraining as DomainEntity;
use Gym\Domain\Exception\PersisterException;

class ExerciseToTrainingPersister implements DomainPersister
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
        $entity = ExerciseToTrainingMapper::fromDomain($domainEntity);

        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }
}
