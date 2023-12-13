<?php

declare(strict_types=1);

namespace Gym\Domain\Query;

use Gym\Domain\Training\TrainingRepository;

class GetTrainingsHandler
{
    private TrainingRepository $repository;

    public function __construct(TrainingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetTrainings $query): array
    {
        return $this->repository->findAllForList();
    }
}
