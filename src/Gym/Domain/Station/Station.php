<?php

declare(strict_types=1);

namespace Gym\Domain\Station;

use App\MergerTrait;
use Symfony\Component\Uid\UuidV1;
use Gym\Domain\Exception\ValidationException;

class Station
{
    use MergerTrait;

    private string $id;
    private string $name;
    private string $photoId;
    private \DateTimeImmutable $createdAt;

    public function __construct(StationDTO $dto)
    {
        $this->merge($dto);
    }

    public function update(StationDTO $dto): void
    {
        $this->merge($dto);
        $this->validate();
    }

    private function validate(): void
    {
        if (!isset($this->id) && UuidV1::isValid($this->id)) {
            throw ValidationException::missingProperty('id');
        }

        if (!isset($this->name) || '' === $this->name) {
            throw ValidationException::missingProperty('name');
        }

        if (!isset($this->photoId) && UuidV1::isValid($this->photoId)) {
            throw ValidationException::missingProperty('photoId');
        }

        if (!isset($this->createdAt)) {
            throw ValidationException::missingProperty('createdAt');
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPhotoId(): string
    {
        return $this->photoId;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
