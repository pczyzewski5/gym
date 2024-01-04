<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Station;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;
use Gym\Domain\Enum\MuscleTagEnum;
use Gym\Domain\Enum\TagOwnerEnum;
use Gym\Domain\Exception\RepositoryException;
use Gym\Domain\Station\StationRepository as DomainRepository;
use Gym\Infrastructure\ExerciseToStation\ExerciseToStation;
use Gym\Infrastructure\Tag\Tag;
use Gym\Domain\Station\Station as DomainEntity;

class StationRepository implements DomainRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getOneById(string $id): DomainEntity
    {
        $entity = $this->entityManager->getRepository(Station::class)->find($id);

        if (null === $entity) {
            throw RepositoryException::notFound(Station::class, $id);
        }

        return StationMapper::toDomain($entity);
    }

    public function findAllForList(): array
    {
        $sql = <<<SQL
SELECT s.id as id, s.name as name, GROUP_CONCAT(t.tag) as tags FROM stations s
    LEFT JOIN exercises_to_stations ets ON ets.station_id = s.id
    LEFT JOIN tags t ON t.owner_id = ets.exercise_id AND t.owner = :owner
GROUP BY s.id
ORDER BY s.name
SQL;
        $stmt = $this->entityManager->getConnection()->executeQuery(
            $sql,
            ['owner' => TagOwnerEnum::EXERCISE],
            ['owner' => Types::STRING]
        );

        return  $stmt->fetchAllAssociative();
    }

    public function findOneForRead(string $id): array
    {
        $sql = <<<SQL
SELECT s.id as id, s.name as name, s.image as image, GROUP_CONCAT(e.id) as exercise_ids, GROUP_CONCAT(e.name) as exercises, GROUP_CONCAT(t.tag) as tags FROM stations s
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
            'exercise_ids' => \explode(',', $data['exercise_ids']),
            'exercises' => \explode(',', $data['exercises']),
            'tags' => \array_unique(
                \explode(',', $data['tags'])
            ),
        ];
    }

    public function findAllByTag(MuscleTagEnum $tagEnum): array
    {
        $qb = $this->entityManager->getRepository(Station::class)
            ->createQueryBuilder('s')
            ->select('s')
            ->leftJoin(ExerciseToStation::class, 'ets', Join::WITH, 'ets.stationId = s.id')
            ->leftJoin(Tag::class, 't', Join::WITH, 't.ownerId = ets.exerciseId')
            ->where('t.tag = :tag')
            ->setParameter('tag', $tagEnum->getValue());

        return StationMapper::mapArrayToDomain(
            $qb->getQuery()->getResult()
        );
    }
}
