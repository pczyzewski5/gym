<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

use Gym\Domain\Training\TrainingDTO;
use Gym\Domain\Training\TrainingPersister;
use Gym\Domain\Training\TrainingRepository;

class UpdateTrainingHandler
{
    private TrainingRepository $repository;
    private TrainingPersister $persister;

    public function __construct(TrainingRepository $repository, TrainingPersister $persister)
    {
        $this->repository = $repository;
        $this->persister = $persister;
    }

    public function handle(UpdateTraining $command): string
    {
        $entity = $this->repository->getOneById(
            $command->getTrainingToUpdateId()
        );

        $dto = new TrainingDTO();
        $dto->status = $command->getStatus();
        $dto->trainingDate = $command->getTrainingDate();
        $dto->trainingStarted = $command->getTrainingStarted();
        $dto->trainingFinished = $command->getTrainingFinished();
        $dto->repeated = $command->getRepeated();

        $entity->update($dto);

        $this->persister->update($entity);

        return $entity->getId();
    }
}
