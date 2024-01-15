<?php

declare(strict_types=1);

namespace Gym\Domain\Enum;

use MyCLabs\Enum\Enum;

class StatusEnum extends Enum
{
    const DONE = 'done';
    const PLANNED = 'planned';
    const IN_PROGRESS = 'in_progress';
}