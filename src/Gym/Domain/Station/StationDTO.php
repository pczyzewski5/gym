<?php

declare(strict_types=1);

namespace Gym\Domain\Station;

class StationDTO
{
    public ?string $id = null;
    public ?string $name = null;
    public ?string $photo = null;
    public ?\DateTimeImmutable $createdAt = null;
}
