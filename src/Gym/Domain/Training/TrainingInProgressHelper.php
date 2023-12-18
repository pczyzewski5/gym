<?php

declare(strict_types=1);

namespace Gym\Domain\Training;

use Gym\Domain\Enum\MuscleTagEnum;
use Gym\Domain\Exercise\Exercise;
use Gym\Domain\Exercise\ExerciseRepository;
use Gym\Domain\Station\Station;
use Gym\Domain\Station\StationRepository;
use Gym\Domain\Tag\Tag;
use Gym\Domain\Tag\TagRepository;

class TrainingInProgressHelper
{
    private TrainingRepository $trainingRepository;
    private TagRepository $tagRepository;
    private StationRepository $stationRepository;
    private ExerciseRepository $exerciseRepository;
    private string $trainingId;

    public function __construct(
        TrainingRepository $trainingRepository,
        TagRepository $tagRepository,
        StationRepository $stationRepository,
        ExerciseRepository $exerciseRepository,
        string $trainingId
    ) {
        $this->trainingRepository = $trainingRepository;
        $this->tagRepository = $tagRepository;
        $this->stationRepository = $stationRepository;
        $this->exerciseRepository = $exerciseRepository;
        $this->trainingId = $trainingId;
    }

    public function getTraining(): Training
    {
        return $this->trainingRepository->getOneById(
            $this->trainingId
        );
    }

    /**
     * @return Tag[]
     */
    public function getTrainingTags(): array
    {
        $result = $this->tagRepository->findAllForOwnerId(
            $this->trainingId
        );

        return \array_map(
            fn (Tag $tag) => $tag->getTag(),
            $result
        );
    }

    /**
     * @return Station[]
     */
    public function getStationsForTag(MuscleTagEnum $tag): array
    {
        return $this->stationRepository->findAllByTag($tag);
    }

    /**
     * @return Exercise[]
     */
    public function getExercisesForStationAndTag(
        Station $station,
        MuscleTagEnum $tagEnum
    ): array {
        return $this->exerciseRepository->findAllByStationAndTag(
            $station,
            $tagEnum
        );
    }
}
