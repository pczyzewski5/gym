<?php

declare(strict_types=1);

namespace Gym\Domain\Exercise;

class ExerciseDTO
{
    public ?string $id = null;
    public ?string $name = null;
    public ?string $description = null;
    public ?bool $separateLoad = null;
    public ?string $image = null;
}
