<?php

declare(strict_types=1);

namespace User\Domain\User;

use User\Domain\Exception\RepositoryException;

interface UserRepository
{
    /**
     * @throws RepositoryException
     */
    public function getOneById(string $id): User;

    /**
     * @return User[]
     */
    public function getManyById(array $userIds): array;

    /**
     * @return User[]
     */
    public function findAllUsers(): array;

    public function findOneById(string $id): ?User;

    public function findUserByEmail(string $username): ?User;
}
