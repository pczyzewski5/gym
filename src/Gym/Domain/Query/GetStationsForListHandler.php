<?php

declare(strict_types=1);

namespace Gym\Domain\Query;

use Gym\Domain\Station\StationRepository;

class GetStationsForListHandler
{
    private StationRepository $repository;

    public function __construct(StationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetStationsForList $query): array
    {
        $stations = \array_map(function (array $item) {
            $tags = \explode(',', $item['tags']);
            $tags = \array_unique($tags);
            \sort($tags);

            $item['tags'] = $tags;

            return $item;
        }, $this->repository->findAllForList());

        \usort($stations, function (array $stationA, array $stationB) {
            return \strcmp($stationA['name'], $stationB['name']);
        });

        $result = [];

        foreach ($stations as $station) {
            foreach ($station['tags'] as $tag) {
                $result[$tag][] = $station;
            }
        }

        \uksort($result, function (string $tagA, string $tagB) {
            return \strcmp($tagA, $tagB);
        });

        return $result;
    }
}
