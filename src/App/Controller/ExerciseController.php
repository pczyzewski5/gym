<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\Form\ExerciseForm;
use App\QueryBus\QueryBus;
use Gym\Domain\Command\CreateExercise;
use Gym\Domain\Enum\StatusEnum;
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
        return $this->renderForm('exercise/list.html.twig', [
            'exercises' => []
        ]);
    }

    public function create(Request $request): Response
    {
        $form = $this->createForm(ExerciseForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle(
                new CreateExercise(
                    $form->getData()[ExerciseForm::MUSCLE_TAG_FIELD],
                    StatusEnum::PLANNED(),
                    $form->getData()[ExerciseForm::REPETITION_TARGET_FIELD],
                    $form->getData()[ExerciseForm::KILOGRAM_TARGET_FIELD]
                )
            );

            return $this->redirectToRoute('training_list');
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
