<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Station;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Gym\Domain\Enum\TagOwnerEnum;
use Gym\Domain\Station\StationRepository as DomainRepository;

class StationRepository implements DomainRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findAllForList(): array
    {
        $sql = <<<SQL
SELECT s.id as id, s.name as name, GROUP_CONCAT(t.tag) as tags FROM stations s
    LEFT JOIN exercises_to_stations ets ON ets.station_id = s.id
    LEFT JOIN tags t ON t.owner_id = ets.exercise_id AND t.owner = :owner
GROUP BY s.id
SQL;
        $stmt = $this->entityManager->getConnection()->executeQuery(
            $sql,
            ['owner' => TagOwnerEnum::EXERCISE],
            ['owner' => Types::STRING]
        );

        return \array_map(
            fn (array $item) => [
                'id' => $item['id'],
                'name' => $item['name'],
                'tags' => \array_unique(
                    \explode(',', $item['tags'])
                )
            ],
            $stmt->fetchAllAssociative()
        );
    }

    public function findOneForRead(string $id): array
    {
        $sql = <<<SQL
SELECT s.id as id, s.name as name, s.image as image, GROUP_CONCAT(e.name) as exercises, GROUP_CONCAT(t.tag) as tags FROM stations s
    LEFT JOIN exercises_to_stations ets ON ets.station_id = s.id
    LEFT JOIN exercises e ON e.id = ets.exercise_id
    LEFT JOIN tags t ON t.owner_id = ets.exercise_id AND t.owner = :owner
WHERE s.id = :id
SQL;
        $stmt = $this->entityManager->getConnection()->executeQuery(
            $sql,
            [
                'id' => $id,
                'owner' => TagOwnerEnum::EXERCISE
            ],
            [
                'id' => Types::STRING,
                'owner' => Types::STRING
            ]
        );

        $data = $stmt->fetchAssociative();

        return [
            'id' => $data['id'],
            'name' => $data['name'],
            'image' => $data['image'],
            'exercises' => \explode(',', $data['exercises']),
            'tags' => \array_unique(
                \explode(',', $data['tags'])
            ),
        ];
    }
}
