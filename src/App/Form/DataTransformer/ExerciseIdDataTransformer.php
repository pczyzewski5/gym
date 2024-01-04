<?php

declare(strict_types=1);

namespace App\Form\DataTransformer;

use Gym\Domain\Enum\MuscleTagEnum;
use Gym\Domain\Exercise\Exercise;
use Gym\Domain\Exercise\ExerciseRepository;
use Symfony\Component\Form\DataTransformerInterface;

class ExerciseIdDataTransformer implements DataTransformerInterface
{
    private ExerciseRepository $repository;

    public function __construct(ExerciseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function transform(mixed $value)
    {
        if (\is_array($value)) {
            $result = [];

            /** @var Exercise $exercise */
            foreach ($value as $exerciseId) {
                $exercise = $this->repository->getOneByIdForRead($exerciseId);

                $result[$exercise['name']] = $exercise['id'];
            }

            return $result;
        }

        return $value;
    }

    public function reverseTransform(mixed $value): MuscleTagEnum|array
    {
        return $value;
    }
}
