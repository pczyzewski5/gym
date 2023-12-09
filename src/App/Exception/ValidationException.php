<?php

declare(strict_types=1);

namespace App\Exception;

class ValidationException extends \Exception
{
    public static function missingProperty($propertyName): self
    {
        return new self(
            \sprintf('%s must be set.', $propertyName)
        );
    }
}
