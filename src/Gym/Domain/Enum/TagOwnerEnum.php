<?php

declare(strict_types=1);

namespace Gym\Domain\Enum;

use MyCLabs\Enum\Enum;

class TagOwnerEnum extends Enum
{
    const EXERCISE = 'exercise';
    const TRAINING = 'training';
}