<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Exercise;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Query\Expr\Join;
use Gym\Domain\Enum\MuscleTagEnum;
use Gym\Domain\Enum\TagOwnerEnum;
use Gym\Domain\Exception\RepositoryException;
use Doctrine\ORM\EntityManagerInterface;
use Gym\Domain\Exercise\Exercise as DomainEntity;
use Gym\Domain\Exercise\ExerciseRepository as DomainRepository;
use Gym\Domain\Station\Station;
use Gym\Infrastructure\ExerciseToStation\ExerciseToStation;
use Gym\Infrastructure\Tag\Tag;

class ExerciseRepository implements DomainRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getOneById(string $id): DomainEntity
    {
        $entity = $this->entityManager->getRepository(Exercise::class)->find($id);

        if (null === $entity) {
            throw RepositoryException::notFound(Exercise::class, $id);
        }

        return ExerciseMapper::toDomain($entity);
    }

    public function getOneByIdForRead(string $id): array
    {
        $sql = <<<SQL
SELECT e.*, t.tag as tag FROM exercises e
    LEFT JOIN tags t ON e.id = t.owner_id AND t.owner = :owner
WHERE e.id = :id
SQL;
        $stmt = $this->entityManager->getConnection()->executeQuery(
            $sql,
            ['id' => $id, 'owner' => TagOwnerEnum::EXERCISE],
            ['id' => Types::STRING, 'owner' => Types::STRING]
        );

        return $stmt->fetchAssociative();
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
SELECT e.id as id, e.name as name, t.tag as tag FROM exercises e
    LEFT JOIN tags t ON e.id = t.owner_id AND t.owner = :owner
GROUP BY e.id
ORDER BY t.tag ASC
SQL;
        $stmt = $this->entityManager->getConnection()->executeQuery(
            $sql,
            ['owner' => TagOwnerEnum::EXERCISE],
            ['owner' => Types::STRING]
        );

        return $stmt->fetchAllAssociative();
    }

    public function findAllByStationAndTag(Station $station, MuscleTagEnum $tagEnum): array
    {
        $qb = $this->entityManager->getRepository(Exercise::class)
            ->createQueryBuilder('e')
            ->select('e')
            ->leftJoin(ExerciseToStation::class, 'ets', Join::WITH, 'ets.exerciseId = e.id')
            ->leftJoin(Tag::class, 't', Join::WITH, 't.ownerId = e.id')
            ->where('ets.stationId = :stationId')
            ->andWhere('t.tag = :tag')
            ->setParameters([
                'stationId' => $station->getId(),
                'tag' => $tagEnum->getValue(),
            ]);

        return ExerciseMapper::mapArrayToDomain(
            $qb->getQuery()->getResult()
        );
    }
}
