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

    public function findAllForOwnerId(string $ownerId): array
    {
        $result = $this->entityManager->getRepository(DomainEntity::class)->find($ownerId);

        return TagMapper::mapArrayToDomain($result);
    }
}
