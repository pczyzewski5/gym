<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\QueryBus\QueryBus;
use Gym\Domain\Query\GetExercise;
use Gym\Domain\Query\GetLiftedWeights;
use Gym\Domain\Query\GetStation;
use Gym\Domain\Query\GetTrainingInProgressHelper;
use Gym\Domain\Training\TrainingInProgressHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TrainingInProgressController extends BaseController
{
    private QueryBus $queryBus;
    private CommandBus $commandBus;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    public function selectExercise(Request $request): Response
    {
        $trainingId = $request->get('trainingId');

        /** @var TrainingInProgressHelper $trainingInProgressHelper */
        $trainingInProgressHelper = $this->queryBus->handle(
            new GetTrainingInProgressHelper($trainingId)
        );

        return $this->renderForm('training_in_progress/select_exercise.html.twig', [
            'helper' => $trainingInProgressHelper,
            'trainingId' => $trainingId,
        ]);
    }

    public function exerciseInProgress(Request $request): Response
    {
        $trainingId = $request->get('trainingId');
        $stationId = $request->get('stationId');
        $exerciseId = $request->get('exerciseId');

        $liftedWeights = $this->queryBus->handle(
            new GetLiftedWeights(
                $trainingId,
                $stationId,
                $exerciseId
            )
        );
        $exercise = $this->queryBus->handle(
            new GetExercise($exerciseId)
        );
        $station = $this->queryBus->handle(
            new GetStation($stationId)
        );

        return $this->renderForm('training_in_progress/exercise_in_progress.html.twig', [
            'trainingId' => $trainingId,
            'exerciseId' => $exerciseId,
            'stationId' => $stationId,
            'liftedWeights' => $liftedWeights,
            'exercise' => $exercise,
            'station' => $station,
        ]);
    }
}
