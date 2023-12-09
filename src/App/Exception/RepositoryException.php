<?php

declare(strict_types=1);

namespace App\Exception;

class RepositoryException extends \Exception
{
    public static function notFound(string $name, string $id): self
    {
        return new self(
            \sprintf('%s with id: %s not found.', $name, $id)
        );
    }
}
