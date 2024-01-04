<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Station;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Gym\Domain\Station\StationPersister as DomainPersister;
use Gym\Domain\Station\Station as DomainEntity;
use Gym\Domain\Exception\PersisterException;

class StationPersister implements DomainPersister
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
        $entity = StationMapper::fromDomain($domainEntity);

        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }

    public function update(DomainEntity $domainEntity): void
    {
        try {
            $sql = 'UPDATE stations
                  SET name = :name,
                      image = :image
                  WHERE id = :id';

            $this->entityManager->getConnection()->executeQuery(
                $sql,
                [
                    'id' => $domainEntity->getId(),
                    'name' => $domainEntity->getName(),
                    'image' => $domainEntity->getImage(),
                ],
                [
                    'id' => Types::STRING,
                    'name' => Types::STRING,
                    'image' => Types::STRING,
                ]
            );
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }

    /**
     * @throws PersisterException
     */
    public function delete(string $id): void
    {
        try {
            $this->entityManager->getConnection()->executeQuery(
                'DELETE FROM stations WHERE id = ?',
                [$id],
                [Types::STRING]
            );
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }
}
