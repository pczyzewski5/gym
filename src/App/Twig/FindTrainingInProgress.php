<?php

declare(strict_types=1);

namespace App\Twig;

use Gym\Domain\Training\TrainingRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Gym\Domain\Training\Training;

class FindTrainingInProgress extends AbstractExtension
{
    private TrainingRepository $repository;

    public function __construct(TrainingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('findTrainingInProgress', [$this, 'handle'])
        ];
    }

    public function handle(): ?Training
    {
        return $this->repository->findTrainingInProgress();
    }
}
