<?php

declare(strict_types=1);

namespace Gym\Domain\Query;

use Gym\Domain\Station\StationRepository;

class GetStationsForReadHandler
{
    private StationRepository $repository;

    public function __construct(StationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetStationsForRead $query): array
    {
        $stations = \array_map(function (array $item) {
            $tags = \explode(',', $item['tags']);
            $tags = \array_unique($tags);
            \sort($tags);

            $item['tags'] = $tags;

            return $item;
        }, $this->repository->findAllForList());

        \usort($stations, function (array $stationA, array $stationB) {
            return \strcmp($stationA['tags'][0], $stationB['tags'][0]);
        });

        return $stations;
    }
}
