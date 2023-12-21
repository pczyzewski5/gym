<?php

declare(strict_types=1);

namespace Gym\Infrastructure\LiftedWeight;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Gym\Domain\Exception\RepositoryException;
use Gym\Domain\LiftedWeight\LiftedWeightRepository as DomainRepository;
use Gym\Domain\LiftedWeight\LiftedWeight as DomainEntity;

class LiftedWeightRepository implements DomainRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findAllBy(
        string $trainingId,
        string $stationId,
        string $exerciseId
    ): array {
        return LiftedWeightMapper::mapArrayToDomain(
            $this->entityManager->getRepository(LiftedWeight::class)->findBy([
                'trainingId' => $trainingId,
                'stationId' => $stationId,
                'exerciseId' => $exerciseId,
            ])
        );
    }

    public function getOneById(string $id): DomainEntity
    {
        $entity = $this->entityManager->getRepository(LiftedWeight::class)->find($id);

        if (null === $entity) {
            throw RepositoryException::notFound(LiftedWeight::class, $id);
        }

        return LiftedWeightMapper::toDomain($entity);
    }

    public function findForTrainingRead(string $trainingId): array
    {
        $sql = <<<SQL
SELECT lw.repetition_count as repetition_count, lw.kilogram_count as kilogram_count, t.tag as tag, s.name as station_name, e.name as exercise_name FROM lifted_weights lw
    LEFT JOIN stations s ON s.id = lw.station_id
    LEFT JOIN exercises e ON e.id = lw.exercise_id
    LEFT JOIN tags t ON t.owner_id = e.id                                                                                                                             
WHERE lw.training_id = :trainingId
SQL;
        $stmt = $this->entityManager->getConnection()->executeQuery(
            $sql,
            ['trainingId' => $trainingId],
            ['trainingId' => Types::STRING]
        );

        $result = [];

        foreach ($stmt->fetchAllAssociative() as $item) {
            $result
            [$item['tag']]
            [$item['station_name']]
            [$item['exercise_name']]
            [] = [
                'repetition_count' => $item['repetition_count'],
                'kilogram_count' => $item['kilogram_count'],
            ];
        }

        return $result;
    }

    public function getLiftedKilogramsCount(string $trainingId): int
    {
        $sql = <<<SQL
SELECT SUM(lw.repetition_count * lw.kilogram_count) FROM lifted_weights lw                                                                                                                          
WHERE lw.training_id = :trainingId
SQL;
        $stmt = $this->entityManager->getConnection()->executeQuery(
            $sql,
            ['trainingId' => $trainingId],
            ['trainingId' => Types::STRING]
        );

        return \intval($stmt->fetchOne());
    }

    public function findLastLiftedWeight(string $stationId, string $exerciseId): ?DomainEntity
    {
        $qb = $this->entityManager->getRepository(LiftedWeight::class)
            ->createQueryBuilder('lw')
            ->where('lw.stationId = :stationId')
            ->andWhere('lw.exerciseId = :exerciseId')
            ->addOrderBy('lw.createdAt', 'DESC')
            ->addOrderBy('lw.repetitionCount', 'DESC')
            ->setMaxResults(1)
            ->setParameters([
                'stationId' => $stationId,
                'exerciseId' => $exerciseId
            ]);

        $result = $qb->getQuery()->getSingleResult();

        return null === $result
            ? null
            : LiftedWeightMapper::toDomain($result);
    }
}
