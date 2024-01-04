<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\Station\StationDTO;
use Gym\Domain\Station\StationPersister;
use Gym\Domain\Station\StationRepository;

class UpdateStationHandler
{
    private StationRepository $repository;
    private StationPersister $persister;

    public function __construct(StationRepository $repository, StationPersister $persister)
    {
        $this->repository = $repository;
        $this->persister = $persister;
    }

    public function handle(UpdateStation $command): string
    {
        $entity = $this->repository->getOneById(
            $command->getId()
        );

        $dto = new StationDTO();
        $dto->name = $command->getName();
        $dto->image = $command->getImage();

        $entity->update($dto);

        $this->persister->update($entity);

        return $entity->getId();
    }
}
