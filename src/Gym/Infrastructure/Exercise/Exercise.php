<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Exercise;

class Exercise
{
    public ?string $id;
    public ?string $name;
    public ?bool $separateLoad;
    public ?string $description;
    public ?string $image;
}
