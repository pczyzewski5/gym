<?php

declare(strict_types=1);

namespace Gym\Domain\Exercise;

use Symfony\Component\Uid\Uuid;

class ExerciseFactory
{
    public static function create(
        string $name,
        string $description,
        bool $separateLoad,
        string $image
    ): Exercise {
        $dto = new ExerciseDTO();
        $dto->id = Uuid::v1()->toRfc4122();
        $dto->name = $name;
        $dto->description = $description;
        $dto->separateLoad = $separateLoad;
        $dto->image = $image;

        return new Exercise($dto);
    }
}
