<?php

declare(strict_types=1);

namespace Gym\Domain\Rest;

class RestFactory
{
    public static function create(

        string $stationId,
        string $exerciseId,
        int $rest,

    ): Rest {
        $dto = new RestDTO();
        $dto->stationId = $stationId;
        $dto->exerciseId = $exerciseId;
        $dto->rest = $rest;

        return new Rest($dto);
    }
}
