<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

class UpdateStation
{
    private string $id;
    private string $name;
    private ?string $image;

    public function __construct(
        string $id,
        string $name,
        ?string $image = null,
    ) {
        $this->id = $id;
        $this->name = $name;
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

    public function getImage(): ?string
    {
        return $this->image;
    }
}
