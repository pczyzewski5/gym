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
    private string $image;

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
        if (isset($this->id) && false === UuidV1::isValid($this->id)) {
            throw ValidationException::missingProperty('id');
        }

        if (!isset($this->name)) {
            throw ValidationException::missingProperty('name');
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

    public function getImage(): string
    {
        return $this->image;
    }
}
