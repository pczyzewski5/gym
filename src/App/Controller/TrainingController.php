<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\Form\ExerciseToTrainingForm;
use App\Form\TrainingForm;
use App\QueryBus\QueryBus;
use Gym\Domain\Command\CreateExerciseToTraining;
use Gym\Domain\Command\CreateTags;
use Gym\Domain\Command\CreateTraining;
use Gym\Domain\Command\DeleteTags;
use Gym\Domain\Command\DeleteTraining;
use Gym\Domain\Enum\StatusEnum;
use Gym\Domain\Enum\TagOwnerEnum;
use Gym\Domain\Query\GetExercise;
use Gym\Domain\Query\GetStation;
use Gym\Domain\Query\GetTrainingInProgressHelper;
use Gym\Domain\Query\GetTrainings;
use Gym\Domain\Training\TrainingInProgressHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TrainingController extends BaseController
{
    private QueryBus $queryBus;
    private CommandBus $commandBus;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    public function inProgress(Request $request): Response
    {
        /** @var TrainingInProgressHelper $trainingInProgressHelper */
        $trainingInProgressHelper = $this->queryBus->handle(
            new GetTrainingInProgressHelper(
                $request->get('id')
            )
        );

        return $this->renderForm('training/in_progress.html.twig', [
            'trainingId' => $request->get('id'),
            'helper' => $trainingInProgressHelper
        ]);
    }

    public function goals(Request $request): Response
    {
        $trainingId = $request->get('trainingId');
        $stationId = $request->get('stationId');
        $exerciseId = $request->get('exerciseId');

        $form = $this->createForm(ExerciseToTrainingForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $exerciseToTrainingId = $this->commandBus->handle(
                new CreateExerciseToTraining(
                    $trainingId,
                    $stationId,
                    $exerciseId,
                    StatusEnum::IN_PROGRESS(),
                    $data[ExerciseToTrainingForm::SERIES_GOAL_FIELD],
                    $data[ExerciseToTrainingForm::REPETITION_GOAL_FIELD],
                    $data[ExerciseToTrainingForm::KILOGRAM_GOAL_FIELD]
                )
            );

            \var_dump($exerciseToTrainingId);exit;
        }

        $exercise = $this->queryBus->handle(
            new GetExercise($exerciseId)
        );
        $station = $this->queryBus->handle(
            new GetStation($stationId)
        );

        return $this->renderForm('training/goals.html.twig', [
            'trainingId' => $trainingId,
            'exercise' => $exercise,
            'station' => $station,
            'form' => $form
        ]);
    }

    public function list(): Response
    {
        $trainings = $this->queryBus->handle(
            new GetTrainings()
        );

        return $this->renderForm('training/list.html.twig', [
            'trainings' => $trainings
        ]);
    }

    public function create(Request $request): Response
    {
        $form = $this->createForm(TrainingForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $trainingId = $this->commandBus->handle(
                new CreateTraining(
                    StatusEnum::PLANNED(),
                    $data[TrainingForm::DATE_FIELD],
                    $data[TrainingForm::REPEATED_FIELD]
                )
            );

            $this->commandBus->handle(
                new CreateTags(
                    $trainingId,
                    TagOwnerEnum::TRAINING(),
                    $data[TrainingForm::TAGS_FIELD]
                )
            );

            return $this->redirectToRoute('training_list');
        }

        return $this->renderForm('training/create.html.twig', [
            'form' => $form
        ]);
    }

    public function delete(Request $request): Response
    {
        throw new \Exception('suit me to new behavour');
        $this->commandBus->handle(
            new DeleteTags(
                $request->get('id'),
                TagOwnerEnum::TRAINING()
            )
        );

        $this->commandBus->handle(
            new DeleteTraining(
                $request->get('id')
            )
        );

        return $this->redirectToRoute('training_list');
    }
}
