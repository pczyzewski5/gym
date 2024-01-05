<?php

declare(strict_types=1);

namespace Gym\Domain\Exercise;

use App\MergerTrait;
use Symfony\Component\Uid\UuidV1;
use Gym\Domain\Exception\ValidationException;

class Exercise
{
    use MergerTrait;

    private string $id;
    private string $name;
    private bool $separateLoad;
    private string $description;
    private string $image;

    public function __construct(ExerciseDTO $dto)
    {
        $this->merge($dto);
    }

    public function update(ExerciseDTO $dto): void
    {
        $this->merge($dto);
        $this->validate();
    }

    private function validate(): void
    {
        if (isset($this->id) && false === UuidV1::isValid($this->id)) {
            throw ValidationException::missingProperty('id');
        }

        if (isset($this->name) && empty($this->name)) {
            throw ValidationException::missingProperty('name');
        }

        if (!isset($this->separateLoad)) {
            throw ValidationException::missingProperty('separateLoad');
        }

        if (isset($this->description) && empty($this->description)) {
            throw ValidationException::missingProperty('description');
        }

        if (isset($this->image) && empty($this->image)) {
            throw ValidationException::missingProperty('image');
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

    public function isSeparateLoad(): bool
    {
        return $this->separateLoad;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImage(): string
    {
        return $this->image;
    }
}
