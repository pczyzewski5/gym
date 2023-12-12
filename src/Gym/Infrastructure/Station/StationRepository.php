<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Station;

use Doctrine\DBAL\Types\Types;
use Gym\Domain\Enum\TagOwnerEnum;
use Gym\Domain\Exception\RepositoryException;
use Doctrine\ORM\EntityManagerInterface;
use Gym\Domain\Station\Station as DomainEntity;
use Gym\Domain\Station\StationRepository as DomainRepository;

class StationRepository implements DomainRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getOneById(string $id): DomainEntity
    {
        $entity = $this->entityManager->getRepository(Station::class)->getOneById($id);

        if (null === $entity) {
            throw RepositoryException::notFound(Station::class, $id);
        }

        return StationMapper::toDomain($entity);
    }

    public function findAllForList(): array
    {
        $sql = <<<SQL
SELECT s.id as id, s.name as name, GROUP_CONCAT(t.tag) as tags FROM stations s
    JOIN tags t ON s.id = t.owner_id AND t.owner = :owner
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

    /**
     * @return DomainEntity[]
     */
    public function findAll(): array
    {
        return StationMapper::mapArrayToDomain(
            $this->entityManager->getRepository(Station::class)->findAll()
        );
    }
}
