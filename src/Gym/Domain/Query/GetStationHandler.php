<?php

declare(strict_types=1);

namespace Gym\Domain\Query;

use Gym\Domain\Station\StationRepository;

class GetStationHandler
{
    private StationRepository $repository;

    public function __construct(StationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetStation $query): array
    {
        return $this->repository->findOneForRead($query->getId());
    }
}
