<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\Form\TrainingForm;
use App\QueryBus\QueryBus;
use Gym\Domain\Command\CreateTraining;
use Gym\Domain\Enum\StatusEnum;
use Gym\Domain\Query\GetTrainings;
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

    public function list(Request $request): Response
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
            $id = $this->commandBus->handle(
                new CreateTraining(
                    StatusEnum::PLANNED(),
                    $form->getData()[TrainingForm::DATE_FIELD],
                    $form->getData()[TrainingForm::REPEATED_FIELD]
                )
            );

            return $this->redirectToRoute('training_read', ['id' => $id]);
        }

        return $this->renderForm('training/create.html.twig', [
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
