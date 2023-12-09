<?php

declare(strict_types=1);

namespace User\Domain\User;

use App\MergerTrait;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\UuidV1;
use User\Domain\Exception\ValidationException;

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use MergerTrait;

    private string $id;
    private string $email;
    private string $username;
    private array $roles;
    private bool $isActive;
    private string $password;
    private \DateTimeImmutable $createdAt;

    public function __construct(UserDTO $dto)
    {
        $this->merge($dto);
    }

    public function update(UserDTO $dto): void
    {
        $this->merge($dto);
        $this->validate();
    }

    private function validate(): void
    {
        // @todo fix validation, ex password cant be empty
        if (!isset($this->id) && UuidV1::isValid($this->id)) {
            throw ValidationException::missingProperty('id');
        }
        
        if (!isset($this->email) || '' === $this->email) {
            throw ValidationException::missingProperty('email');
        }

        if (!isset($this->username) || '' === $this->username) {
            throw ValidationException::missingProperty('username');
        }

        if (!isset($this->roles) || empty($this->roles)) {
            throw ValidationException::missingProperty('roles');
        }

        if (!isset($this->password) || '' === $this->password) {
            throw ValidationException::missingProperty('password');
        }

        if (!\is_bool($this->isActive)) {
            throw ValidationException::missingProperty('is_active');
        }

        if (!isset($this->createdAt)) {
            throw ValidationException::missingProperty('createdAt');
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function hasRole(string $role): bool
    {
        return \in_array($role, $this->roles);
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}
