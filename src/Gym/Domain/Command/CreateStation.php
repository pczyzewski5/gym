<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\Enum\MuscleTagEnum;

class CreateStation
{
    private string $name;
    private string $photo;
    private array $tags;

    public function __construct(
        string $name,
        string $photo,
        array $tags
    ) {
        $this->name = $name;
        $this->photo = $photo;
        $this->tags = $tags;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }

    /**
     * @return MuscleTagEnum[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }
}
