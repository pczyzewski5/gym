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
        $sql = <<<SQL
SELECT tr.id as id, tr.date as date, tr.repeated as repeated, tr.status as status, GROUP_CONCAT(t.tag) as tags FROM trainings tr
    LEFT JOIN tags t ON t.owner_id = tr.id AND t.owner = :owner
GROUP BY tr.id
SQL;
        $stmt = $this->entityManager->getConnection()->executeQuery(
            $sql,
            ['owner' => TagOwnerEnum::TRAINING],
            ['owner' => Types::STRING]
        );

        return \array_map(function (array $item) {
            $tags = \explode(',', $item['tags']);
            $tags = \array_count_values($tags);
            $countedTags = [];

            foreach ($tags as $tag => $count) {
                $countedTags[] = $count > 1 ? $count . 'x ' . $tag : $tag;
            }

            return [
                'id' => $item['id'],
                'date' => \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $item['date']),
                'repeated' => (bool)$item['repeated'],
                'status' => $item['status'],
                'tags' => $countedTags
            ];
        }, $stmt->fetchAllAssociative());
    }
}
