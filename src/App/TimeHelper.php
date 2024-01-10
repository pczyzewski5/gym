<?php

declare(strict_types=1);

namespace App;

use DateTimeInterface;

class TimeHelper
{
    public static function calculateDiffInMinutes(DateTimeInterface $dateTimeA, DateTimeInterface $dateTimeB): int
    {
        return \intval(
            ($dateTimeA->format('U') - $dateTimeB->format('U')) / 60
        );
    }
}
