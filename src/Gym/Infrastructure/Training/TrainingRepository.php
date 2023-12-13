<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Training;

use Doctrine\DBAL\Types\Types;
use Gym\Domain\Enum\TagOwnerEnum;
use Gym\Domain\Exception\RepositoryException;
use Doctrine\ORM\EntityManagerInterface;
use Gym\Domain\Training\Training as DomainEntity;
use Gym\Domain\Training\TrainingRepository as DomainRepository;

class TrainingRepository implements DomainRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getOneById(string $id): DomainEntity
    {
        $entity = $this->entityManager->getRepository(Training::class)->getOneById($id);

        if (null === $entity) {
            throw RepositoryException::notFound(Training::class, $id);
        }

        return TrainingMapper::toDomain($entity);
    }

    /**
     * @return DomainEntity[]
     */
    public function findAll(): array
    {
        return TrainingMapper::mapArrayToDomain(
            $this->entityManager->getRepository(Training::class)->findAll()
        );
    }

    public function findAllForList(): array
    {
        return [];
        $sql = <<<SQL
SELECT t.id as id, t.date as date, t.repeated as repeated, GROUP_CONCAT(t.tag) as tags FROM trainings t
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
                'kilogram_target' => $item['kilogram_target'],
                'tags' => \explode(',', $item['tags']),
            ],
            $stmt->fetchAllAssociative()
        );
    }
}
