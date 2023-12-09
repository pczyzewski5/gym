<?php

declare(strict_types=1);

namespace User\Domain\User;

class UserDTO
{
    public ?string $id = null;
    public ?string $email = null;
    public ?string $username = null;
    public ?array $roles = null;
    public ?string $password = null;
    public ?bool $isActive = null;
    public ?\DateTimeImmutable $createdAt = null;
}
