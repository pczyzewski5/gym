<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\Enum\StatusEnum;
use Symfony\Component\Uid\AbstractUid;

class ChangeTrainingStatus
{
    private AbstractUid $id;
    private StatusEnum $status;

    public function __construct(AbstractUid $id, StatusEnum $status)
    {
        $this->id = $id;
        $this->status = $status;
    }

    public function getId(): AbstractUid
    {
        return $this->id;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }
}
