<?php

declare(strict_types=1);

namespace Gym\Infrastructure\Tag;

use Doctrine\ORM\EntityManagerInterface;
use Gym\Domain\Tag\TagRepository as DomainRepository;
use Gym\Domain\Tag\Tag as DomainEntity;

class TagRepository implements DomainRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return DomainEntity[]
     */
    public function findAllForOwnerId(string $ownerId): array
    {
        $qb = $this->entityManager->getRepository(Tag::class)
            ->createQueryBuilder('t')
            ->where('t.ownerId = :ownerId')
            ->setParameter('ownerId', $ownerId)
            ->groupBy('t.tag');

        return TagMapper::mapArrayToDomain(
            $qb->getQuery()->getResult()
        );
    }
}
