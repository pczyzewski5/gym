<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\Form\ExerciseForm;
use App\Form\StationForm;
use App\QueryBus\QueryBus;
use Gym\Domain\Command\CreateExercise;
use Gym\Domain\Command\CreateTags;
use Gym\Domain\Enum\StatusEnum;
use Gym\Domain\Enum\TagOwnerEnum;
use Gym\Domain\Query\GetExercises;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExerciseController extends BaseController
{
    private QueryBus $queryBus;
    private CommandBus $commandBus;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    public function list(Request $request): Response
    {
        $exercises = $this->queryBus->handle(
            new GetExercises()
        );

        return $this->renderForm('exercise/list.html.twig', [
            'exercises' => $exercises
        ]);
    }

    public function create(Request $request): Response
    {
        $form = $this->createForm(ExerciseForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $id = $this->commandBus->handle(
                new CreateExercise(
                    StatusEnum::PLANNED(),
                    $data[ExerciseForm::SERIES_TARGET_FIELD],
                    $data[ExerciseForm::REPETITION_TARGET_FIELD],
                )
            );

            $this->commandBus->handle(
                new CreateTags(
                    $id,
                    TagOwnerEnum::EXERCISE(),
                    $data[StationForm::TAGS_FIELD]
                )
            );

            return $this->redirectToRoute('exercise_list');
        }

        return $this->renderForm('exercise/create.html.twig', [
            'form' => $form
        ]);
    }

    public function read(Request $request): Response
    {
        return $this->renderForm('training/read.html.twig', [
            'id' => $request->get('id')
        ]);
    }
    public function update(Request $request): Response
    {

    }

    public function delete(Request $request): Response
    {

    }
}
