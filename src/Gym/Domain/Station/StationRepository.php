<?php

declare(strict_types=1);

namespace Gym\Domain\Station;

use Gym\Domain\Enum\MuscleTagEnum;

interface StationRepository
{
    public function findAllForList(): array;

    /**
     * @return Station[]
     */
    public function findAllByTag(MuscleTagEnum $tagEnum): array;

    public function findOneForRead(string $id): array;
}
