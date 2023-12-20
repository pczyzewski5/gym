<?php

declare(strict_types=1);

namespace Gym\Domain\Query;

use Gym\Domain\Exercise\ExerciseRepository;
use Gym\Domain\Station\StationRepository;
use Gym\Domain\Tag\TagRepository;
use Gym\Domain\Training\TrainingInProgressHelper;
use Gym\Domain\Training\TrainingRepository;
use Gym\Infrastructure\LiftedWeight\LiftedWeightRepository;

class GetTrainingInProgressHelperHandler
{
    private TrainingRepository $trainingRepository;
    private TagRepository $tagRepository;
    private StationRepository $stationRepository;
    private ExerciseRepository $exerciseRepository;
    private LiftedWeightRepository $liftedWeightRepository;

    public function __construct(
        TrainingRepository $trainingRepository,
        TagRepository $tagRepository,
        StationRepository $stationRepository,
        ExerciseRepository $exerciseRepository,
        LiftedWeightRepository $liftedWeightRepository
    ) {
        $this->trainingRepository = $trainingRepository;
        $this->tagRepository = $tagRepository;
        $this->stationRepository = $stationRepository;
        $this->exerciseRepository = $exerciseRepository;
        $this->liftedWeightRepository = $liftedWeightRepository;
    }

    public function __invoke(GetTrainingInProgressHelper $query): TrainingInProgressHelper
    {
        return new TrainingInProgressHelper(
            $this->trainingRepository,
            $this->tagRepository,
            $this->stationRepository,
            $this->exerciseRepository,
            $this->liftedWeightRepository,
            $query->getTrainingId()
        );
    }
}
