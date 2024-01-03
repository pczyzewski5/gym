<?php

declare(strict_types=1);

namespace Gym\Domain\Query;

use Gym\Domain\Exercise\ExerciseRepository;

class GetExerciseForReadHandler
{
    private ExerciseRepository $repository;

    public function __construct(ExerciseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetExerciseForRead $query): array
    {
        return $this->repository->getOneByIdForRead(
            $query->getId()
        );
    }
}
