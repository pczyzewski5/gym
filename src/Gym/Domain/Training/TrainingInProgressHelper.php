<?php

declare(strict_types=1);

namespace Gym\Domain\Training;

use Gym\Domain\Enum\MuscleTagEnum;
use Gym\Domain\Enum\StatusEnum;
use Gym\Domain\Exercise\Exercise;
use Gym\Domain\Exercise\ExerciseRepository;
use Gym\Domain\LiftedWeight\LiftedWeightRepository;
use Gym\Domain\Station\Station;
use Gym\Domain\Station\StationRepository;
use Gym\Domain\Tag\Tag;
use Gym\Domain\Tag\TagRepository;

class TrainingInProgressHelper
{
    private TagRepository $tagRepository;
    private StationRepository $stationRepository;
    private ExerciseRepository $exerciseRepository;
    private LiftedWeightRepository $liftedWeightRepository;
    private Training $training;

    public function __construct(
        TrainingRepository     $trainingRepository,
        TagRepository          $tagRepository,
        StationRepository      $stationRepository,
        ExerciseRepository     $exerciseRepository,
        LiftedWeightRepository $liftedWeightRepository,
        string                 $trainingId
    )
    {
        $this->tagRepository = $tagRepository;
        $this->stationRepository = $stationRepository;
        $this->exerciseRepository = $exerciseRepository;
        $this->liftedWeightRepository = $liftedWeightRepository;

        $this->training = $trainingRepository->getOneById($trainingId);
    }

    public function getTraining(): Training
    {
        return $this->training;
    }

    public function getTrainingDurationInMinutes(): int
    {
        if (StatusEnum::IN_PROGRESS()->equals($this->training->getStatus())) {
            $diff = time() - $this->training->getTrainingStarted()->format('U');

            return \intval($diff / 60);
        }

        return 0;
    }

    /**
     * @return Tag[]
     */
    public function getTrainingTags(): array
    {
        $result = $this->tagRepository->findAllForOwnerId(
            $this->training->getId()
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

    public function getSeriesCount($stationId, $exerciseId): int
    {
        $result = $this->liftedWeightRepository->findAllBy(
            $this->training->getId(),
            $stationId,
            $exerciseId
        );

        return \count($result);
    }
}
