<?php

declare(strict_types=1);

namespace Gym\Domain\Query;

use Gym\Domain\Training\TrainingRepository;
use Gym\Domain\Training\Training;

class GetTrainingHandler
{
    private TrainingRepository $repository;

    public function __construct(TrainingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetTraining $query): Training
    {
        return $this->repository->getOneById(
            $query->getId()
        );
    }
}
