<?php

declare(strict_types=1);

namespace Gym\Infrastructure\ExerciseToStation;

use Doctrine\ORM\EntityManagerInterface;
use Gym\Domain\ExerciseToStation\ExerciseToStationRepository as DomainRepository;

class ExerciseToStationRepository implements DomainRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findAllWithNames(): array
    {
        $sql = <<<SQL
SELECT ets.exercise_id, e.name as exercise_name, ets.station_id, s.name as station_name  FROM exercises_to_stations ets
JOIN exercises e ON e.id = ets.exercise_id
JOIN stations s ON s.id = ets.station_id
ORDER BY e.name ASC
SQL;
        $stmt = $this->entityManager->getConnection()->executeQuery($sql);

        return $stmt->fetchAllAssociative();
    }
}
