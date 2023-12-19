<?php

declare(strict_types=1);

namespace Gym\Infrastructure\ExerciseToTraining;

use Doctrine\ORM\EntityManagerInterface;
use Gym\Domain\ExerciseToTraining\ExerciseToTrainingRepository as DomainRepository;
use Gym\Domain\ExerciseToTraining\ExerciseToTraining as DomainEntity;

class ExerciseToTrainingRepository implements DomainRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
