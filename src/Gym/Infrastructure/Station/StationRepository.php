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
    LEFT JOIN tags t ON s.id = t.owner_id AND t.owner = :owner
GROUP BY s.id
SQL;
        $stmt = $this->entityManager->getConnection()->executeQuery(
            $sql,
            ['owner' => TagOwnerEnum::STATION],
            ['owner' => Types::STRING]
        );

        return \array_map(
            fn (array $item) => [
                'id' => $item['id'],
                'name' => $item['name'],
                'tags' => \explode(',', $item['tags']),
            ],
            $stmt->fetchAllAssociative()
        );
    }

    public function findOneForRead(string $id): array
    {
        $sql = <<<SQL
SELECT s.id as id, s.name as name, s.photo as photo, GROUP_CONCAT(t.tag) as tags FROM stations s
    JOIN tags t ON s.id = t.owner_id AND t.owner = :owner
WHERE s.id = :id
SQL;
        $stmt = $this->entityManager->getConnection()->executeQuery(
            $sql,
            [
                'id' => $id,
                'owner' => TagOwnerEnum::STATION
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
            'photo' => $data['photo'],
            'tags' => \explode(',', $data['tags']),
        ];
    }
}
