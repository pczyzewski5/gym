<?php

declare(strict_types=1);

namespace User\Infrastructure\User;

class User
{
    public ?string $id;
    public ?string $email;
    public ?string $username;
    public ?string $roles;
    public ?string $password;
    public ?bool $isActive;
    public ?\DateTime $createdAt;
}
