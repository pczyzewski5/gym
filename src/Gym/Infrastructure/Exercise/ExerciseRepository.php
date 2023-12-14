<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Exercise;

use Doctrine\DBAL\Types\Types;
use Gym\Domain\Enum\TagOwnerEnum;
use Gym\Domain\Exception\RepositoryException;
use Doctrine\ORM\EntityManagerInterface;
use Gym\Domain\Exercise\Exercise as DomainEntity;
use Gym\Domain\Exercise\ExerciseRepository as DomainRepository;

class ExerciseRepository implements DomainRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getOneById(string $id): DomainEntity
    {
        $entity = $this->entityManager->getRepository(Exercise::class)->getOneById($id);

        if (null === $entity) {
            throw RepositoryException::notFound(Exercise::class, $id);
        }

        return ExerciseMapper::toDomain($entity);
    }

    /**
     * @return DomainEntity[]
     */
    public function findAll(): array
    {
        return ExerciseMapper::mapArrayToDomain(
            $this->entityManager->getRepository(Exercise::class)->findAll()
        );
    }

    public function findAllForList(): array
    {
        $sql = <<<SQL
SELECT e.id as id, e.series_target as series_target, e.repetition_target as repetition_target, GROUP_CONCAT(t.tag) as tags FROM exercises e
    LEFT JOIN tags t ON e.id = t.owner_id AND t.owner = :owner
GROUP BY e.id
SQL;
        $stmt = $this->entityManager->getConnection()->executeQuery(
            $sql,
            ['owner' => TagOwnerEnum::EXERCISE],
            ['owner' => Types::STRING]
        );

        return \array_map(
            fn (array $item) => [
                'id' => $item['id'],
                'series_target' => $item['series_target'],
                'repetition_target' => $item['repetition_target'],
                'tags' => \explode(',', $item['tags']),
            ],
            $stmt->fetchAllAssociative()
        );
    }
}
