<?php

declare(strict_types=1);

namespace User\Infrastructure\User;

use DateTime;
use User\Domain\User\User as DomainEntity;
use User\Domain\User\UserDTO;
use App\DateTimeNormalizer;

class UserMapper
{
    public static function toDomain(User $entity): DomainEntity
    {
        $dto = new UserDTO();
        $dto->id = $entity->id;
        $dto->email = $entity->email;
        $dto->username = $entity->username;
        $dto->roles = \json_decode($entity->roles);
        $dto->password = $entity->password;
        $dto->isActive = $entity->isActive;
        $dto->createdAt = DateTimeNormalizer::normalizeToImmutable(
            $entity->createdAt
        );

        return new DomainEntity($dto);
    }

    public static function fromDomain(
        DomainEntity $domainEntity
    ): User {
        $entity = new User();
        $entity->id = $domainEntity->getId();
        $entity->email = $domainEntity->getEmail();
        $entity->username = $domainEntity->getUsername();
        $entity->roles = \json_encode($domainEntity->getRoles());
        $entity->password = $domainEntity->getPassword();
        $entity->isActive = $domainEntity->isActive();
        $entity->createdAt = DateTime::createFromImmutable(
            $domainEntity->getCreatedAt()
        );

        return $entity;
    }

    /**
     * @return DomainEntity[]
     */
    public static function mapArrayToDomain(array $entities): array
    {
        return \array_map(
            static fn (User $entity) => self::toDomain($entity),
            $entities
        );
    }
}
