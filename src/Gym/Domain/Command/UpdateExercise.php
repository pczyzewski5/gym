<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

class UpdateExercise
{
    private string $id;
    private string $name;
    private string $description;
    private ?string $image;

    public function __construct(
        string $id,
        string $name,
        string $description,
        ?string $image = null,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->image = $image;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }
}
