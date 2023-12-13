<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Tag;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Gym\Domain\Enum\TagOwnerEnum;
use Gym\Domain\Tag\TagPersister as DomainPersister;
use Gym\Domain\Tag\Tag as DomainEntity;
use Gym\Domain\Exception\PersisterException;

class TagPersister implements DomainPersister
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
        $entity = TagMapper::fromDomain($domainEntity);

        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }

    public function deleteMany(string $ownerId, TagOwnerEnum $owner): void
    {
        $sql = <<<SQL
DELETE FROM tags WHERE owner_id = :ownerId AND owner = :owner
SQL;
        $this->entityManager->getConnection()->executeQuery(
            $sql,
            [
                'ownerId' => $ownerId,
                'owner' => $owner->getValue()
            ],
            [
                'ownerId' => Types::STRING,
                'owner' => Types::STRING
            ]
        );
    }
}
