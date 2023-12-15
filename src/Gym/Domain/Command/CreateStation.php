<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

class CreateStation
{
    private string $name;
    private string $image;

    public function __construct(
        string $name,
        string $photo,
    ) {
        $this->name = $name;
        $this->image = $photo;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getImage(): string
    {
        return $this->image;
    }
}
