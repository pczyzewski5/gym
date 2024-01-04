<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\Enum\MuscleTagEnum;
use Gym\Domain\Tag\TagFactory;
use Gym\Domain\Tag\TagPersister;

class PutTagsHandler
{
    private TagPersister $persister;

    public function __construct(TagPersister $persister)
    {
        $this->persister = $persister;
    }

    public function handle(PutTags $command): void
    {
        $this->persister->deleteMany(
            $command->getOwnerId(),
            $command->getOwner()
        );

        /** @var MuscleTagEnum $tag */
        foreach ($command->getTags() as $tag) {
            $entity = TagFactory::create(
                $command->getOwnerId(),
                $command->getOwner(),
                $tag,
            );

            $this->persister->save($entity);
        }
    }
}
