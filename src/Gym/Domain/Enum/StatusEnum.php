<?php

namespace Gym\Domain\Enum;

use MyCLabs\Enum\Enum;

class StatusEnum extends Enum
{
    const DONE = 'done';
    const PLANNED = 'planned';
    const IN_PROGRESS = 'in_progress';
}