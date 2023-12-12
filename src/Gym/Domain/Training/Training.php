<?php

declare(strict_types=1);

namespace Gym\Domain\Training;

use App\MergerTrait;
use Symfony\Component\Uid\UuidV1;
use Gym\Domain\Exception\ValidationException;

class Training
{
    use MergerTrait;

    private string $id;
    private string $status;
    private \DateTimeImmutable $date;
    private \DateTimeImmutable $createdAt;

    public function __construct(TrainingDTO $dto)
    {
        $this->merge($dto);
    }

    public function update(TrainingDTO $dto): void
    {
        $this->merge($dto);
        $this->validate();
    }

    private function validate(): void
    {
        if (!isset($this->id) && UuidV1::isValid($this->id)) {
            throw ValidationException::missingProperty('id');
        }

        if (!isset($this->status) || '' === $this->status) {
            throw ValidationException::missingProperty('status');
        }

        if (!isset($this->date)) {
            throw ValidationException::missingProperty('date');
        }

        if (!isset($this->createdAt)) {
            throw ValidationException::missingProperty('createdAt');
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
