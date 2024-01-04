<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\Form\TrainingForm;
use App\QueryBus\QueryBus;
use Gym\Domain\Command\ChangeTrainingStatus;
use Gym\Domain\Command\CreateTraining;
use Gym\Domain\Command\DeleteTags;
use Gym\Domain\Command\DeleteTraining;
use Gym\Domain\Command\PutTags;
use Gym\Domain\Enum\StatusEnum;
use Gym\Domain\Enum\TagOwnerEnum;
use Gym\Domain\Query\GetLiftedKilogramsCount;
use Gym\Domain\Query\GetLiftedWeightsForTrainingRead;
use Gym\Domain\Query\GetTraining;
use Gym\Domain\Query\GetTrainings;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

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

    public function changeStatus(Request $request): Response
    {
        $payload = \json_decode($request->getContent(), true);

        $actualStatus = StatusEnum::from($payload['actual_status']);
        $status = $actualStatus->equals(StatusEnum::IN_PROGRESS())
            ? StatusEnum::DONE()
            : StatusEnum::IN_PROGRESS();

        $this->commandBus->handle(
            new ChangeTrainingStatus(
                Uuid::fromRfc4122($payload['training_id']),
                $status
            )
        );

        return new Response($status->getValue(), Response::HTTP_OK);
    }
}
