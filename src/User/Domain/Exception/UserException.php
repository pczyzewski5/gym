<?php

declare(strict_types=1);

namespace User\Domain\Exception;

class UserException extends ValidationException
{
    public static function notActive() {
        return new self('User is not activated yet.');
    }
}
