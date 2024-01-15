<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\Tag\TagPersister;

class DeleteTagsHandler
{
    private TagPersister $persister;

    public function __construct(TagPersister $persister)
    {
        $this->persister = $persister;
    }

    public function handle(DeleteTags $command): void
    {
        $this->persister->deleteMany(
            $command->getOwnerId(),
            $command->getOwner()
        );
    }
}
