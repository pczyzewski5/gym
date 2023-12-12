<?php

declare(strict_types=1);

namespace Gym\Domain\Query;

use Gym\Domain\Station\StationRepository;

class GetStationsHandler
{
    private StationRepository $repository;

    public function __construct(StationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetStations $query): array
    {
        return $this->repository->findAllForList();
    }
}
