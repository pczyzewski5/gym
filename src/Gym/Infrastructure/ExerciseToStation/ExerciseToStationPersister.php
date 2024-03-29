<?php

declare(strict_types=1);

namespace Gym\Infrastructure\ExerciseToStation;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Gym\Domain\ExerciseToStation\ExerciseToStationPersister as DomainPersister;
use Gym\Domain\ExerciseToStation\ExerciseToStation as DomainEntity;
use Gym\Domain\Exception\PersisterException;

class ExerciseToStationPersister implements DomainPersister
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws PersisterException
     */
    public function save(DomainEntity $domainEntity): void
    {
        $entity = ExerciseToTrainingMapper::fromDomain($domainEntity);

        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }

    /**
     * @throws PersisterException
     */
    public function deleteManyByStationId(string $stationId): void
    {
        $sql = <<<SQL
DELETE FROM exercises_to_stations WHERE station_id = :stationId
SQL;
        $this->entityManager->getConnection()->executeQuery(
            $sql,
            ['stationId' => $stationId],
            ['stationId' => Types::STRING]
        );
    }
}
