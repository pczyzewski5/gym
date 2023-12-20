<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Training;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Gym\Domain\Enum\StatusEnum;
use Gym\Domain\Training\TrainingPersister as DomainPersister;
use Gym\Domain\Training\Training as DomainEntity;
use Gym\Domain\Exception\PersisterException;

class TrainingPersister implements DomainPersister
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
        $entity = TrainingMapper::fromDomain($domainEntity);

        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }

    public function update(DomainEntity $domainEntity): void
    {

    }

    /**
     * @throws PersisterException
     */
    public function delete(string $id): void
    {
        try {
            $this->entityManager->getConnection()->executeQuery(
                'DELETE FROM trainings WHERE id = ?',
                [$id],
                [Types::STRING]
            );
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }

    public function updateStatus(string $id, StatusEnum $status): void
    {
        try {
            $this->entityManager->getConnection()->executeQuery(
                'UPDATE trainings SET status = :status WHERE id = :id',
                [
                    'status' => $status->getValue(),
                    'id' => $id
                ],
                [
                    'status' => Types::STRING,
                    'id' => Types::STRING
                ]
            );
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }
}
