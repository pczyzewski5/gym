<?php

declare(strict_types=1);

namespace Gym\Domain\Station;

interface StationRepository
{
    public function findAllForList(): array;

    public function findOneForRead(string $id): array;
}
