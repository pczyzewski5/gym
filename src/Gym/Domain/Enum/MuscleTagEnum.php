<?php

declare(strict_types=1);

namespace Gym\Domain\Enum;

use MyCLabs\Enum\Enum;

class MuscleTagEnum extends Enum
{
    const BICEPS = 'biceps';
    const TRICEPS = 'triceps';
    const BACK = 'plecy';
    const CHEST = 'klata';
    const SHOULDERS = 'barki';
    const BELLY = 'brzuch';
}