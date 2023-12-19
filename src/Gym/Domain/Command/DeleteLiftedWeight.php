<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Symfony\Component\Uid\AbstractUid;

class DeleteLiftedWeight
{
    private AbstractUid $id;

    public function __construct(AbstractUid $id)
    {
        $this->id = $id;
    }

    public function getId(): AbstractUid
    {
        return $this->id;
    }
}
