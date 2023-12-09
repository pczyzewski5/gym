<?php

declare(strict_types=1);

namespace App\Exception;

class PersisterException extends \Exception
{
    private function __construct(\Throwable $exception)
    {
        parent::__construct(
            $exception->getMessage(),
            0,
            $exception
        );
    }

    public static function fromThrowable(\Throwable $exception): self
    {
        return new self($exception);
    }
}
