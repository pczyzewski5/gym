<?php

declare(strict_types=1);

namespace Gym\Domain\Tag;

use App\MergerTrait;
use Gym\Domain\Enum\MuscleTagEnum;
use Gym\Domain\Enum\TagOwnerEnum;
use Symfony\Component\Uid\UuidV1;
use Gym\Domain\Exception\ValidationException;

class Tag
{
    use MergerTrait;

    private string $id;
    private string $ownerId;
    private TagOwnerEnum $owner;
    private MuscleTagEnum $tag;

    public function __construct(TagDTO $dto)
    {
        $this->merge($dto);
    }

    public function update(TagDTO $dto): void
    {
        $this->merge($dto);
        $this->validate();
    }

    private function validate(): void
    {
        if (!isset($this->id) && UuidV1::isValid($this->id)) {
            throw ValidationException::missingProperty('id');
        }

        if (!isset($this->ownerId) && UuidV1::isValid($this->ownerId)) {
            throw ValidationException::missingProperty('ownerId');
        }

        if (!isset($this->owner) ) {
            throw ValidationException::missingProperty('owner');
        }

        if (!isset($this->tag) ) {
            throw ValidationException::missingProperty('tag');
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getOwnerId(): string
    {
        return $this->ownerId;
    }

    public function getOwner(): TagOwnerEnum
    {
        return $this->owner;
    }

    public function getTag(): MuscleTagEnum
    {
        return $this->tag;
    }
}
