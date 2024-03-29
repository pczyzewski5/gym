<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\Form\TrainingForm;
use App\QueryBus\QueryBus;
use Gym\Domain\Command\CreateTraining;
use Gym\Domain\Command\DeleteTags;
use Gym\Domain\Command\DeleteTraining;
use Gym\Domain\Command\PutTags;
use Gym\Domain\Command\UpdateTraining;
use Gym\Domain\Enum\StatusEnum;
use Gym\Domain\Enum\TagOwnerEnum;
use Gym\Domain\Query\GetLiftedKilogramsCount;
use Gym\Domain\Query\GetLiftedWeightsForTrainingRead;
use Gym\Domain\Query\GetTraining;
use Gym\Domain\Query\FindTrainingsForList;
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

    public function list(): Response
    {
        $trainingsByYear = $this->queryBus->handle(
            new FindTrainingsForList()
        );

        return $this->renderForm('training/list.html.twig', [
            'trainingsByYear' => $trainingsByYear
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
                new PutTags(
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

    public function read(Request $request): Response
    {
        $training = $this->queryBus->handle(
            new GetTraining(
                $request->get('id')
            )
        );
        $liftedWeights = $this->queryBus->handle(
            new GetLiftedWeightsForTrainingRead(
                $request->get('id')
            )
        );
        $liftedKilograms = $this->queryBus->handle(
            new GetLiftedKilogramsCount(
                $request->get('id')
            )
        );

        return $this->renderForm('training/read.html.twig', [
            'training' => $training,
            'liftedWeights' => $liftedWeights,
            'liftedKilograms' => $liftedKilograms
        ]);
    }

    public function delete(Request $request): Response
    {
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

    public function updateStatus(Request $request): Response
    {
        $id = $request->get('id');
        $status = $request->get('status');

        $this->commandBus->handle(
            new UpdateTraining(
                $id,
                StatusEnum::from($status),
                null,
                StatusEnum::IN_PROGRESS === $status ? new \DateTimeImmutable() : null,
                StatusEnum::DONE === $status ? new \DateTimeImmutable() : null,
            )
        );

        return StatusEnum::IN_PROGRESS === $status
            ? $this->redirectToRoute('training_in_progress_select_exercise', ['id' => $id])
            : $this->redirectToRoute('training_list');
    }
}
