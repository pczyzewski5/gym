<?php

declare(strict_types=1);

namespace App\Controller;

use App\Command\UploadFile;
use App\CommandBus\CommandBus;
use App\Form\ExerciseForm;
use App\Form\StationForm;
use App\QueryBus\QueryBus;
use Gym\Domain\Command\CreateExercise;
use Gym\Domain\Command\CreateTags;
use Gym\Domain\Command\DeleteExercise;
use Gym\Domain\Command\DeleteImage;
use Gym\Domain\Command\DeleteTags;
use Gym\Domain\Enum\TagOwnerEnum;
use Gym\Domain\Query\GetExercise;
use Gym\Domain\Query\GetExerciseForRead;
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

            $image = $this->commandBus->handle(
                new UploadFile($data[StationForm::IMAGE_FIELD])
            );

            $id = $this->commandBus->handle(
                new CreateExercise(
                    $data[ExerciseForm::NAME_FIELD],
                    $data[ExerciseForm::DESCRIPTION_FIELD],
                    $image,
                )
            );

            $this->commandBus->handle(
                new CreateTags(
                    $id,
                    TagOwnerEnum::EXERCISE(),
                    $data[ExerciseForm::TAG_FIELD]
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
        $exercise = $this->queryBus->handle(
            new GetExerciseForRead($request->get('id'))
        );

        return $this->renderForm('exercise/read.html.twig', [
            'exercise' => $exercise
        ]);
    }

    public function update(Request $request): Response
    {

    }

    public function delete(Request $request): Response
    {
        $exercise = $this->queryBus->handle(
            new GetExercise($request->get('id'))
        );

        $this->commandBus->handle(
            new DeleteTags(
                $exercise->getId(),
                TagOwnerEnum::EXERCISE()
            )
        );
        $this->commandBus->handle(
            new DeleteImage(
                $exercise->getImage()
            )
        );
        $this->commandBus->handle(
            new DeleteExercise(
                $exercise->getId()
            )
        );

        return $this->redirectToRoute('exercise_list');
    }
}
