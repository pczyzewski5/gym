<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\Form\ExerciseToTrainingForm;
use App\QueryBus\QueryBus;
use Gym\Domain\Command\CreateExerciseToTraining;
use Gym\Domain\Enum\StatusEnum;
use Gym\Domain\Query\GetExercise;
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
        $exercise = $this->queryBus->handle(
            new GetExercise( $request->get('exerciseId'))
        );
        $station = $this->queryBus->handle(
            new GetStation($request->get('stationId'))
        );

        return $this->renderForm('training_in_progress/exercise_in_progress.html.twig', [
            'trainingId' => $request->get('trainingId'),
            'exercise' => $exercise,
            'station' => $station,
        ]);
    }
}
