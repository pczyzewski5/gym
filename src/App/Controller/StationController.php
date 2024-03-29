<?php

declare(strict_types=1);

namespace App\Controller;

use App\Command\UploadFile;
use App\CommandBus\CommandBus;
use App\Form\StationForm;
use App\QueryBus\QueryBus;
use Gym\Domain\Command\PutExercisesToStation;
use Gym\Domain\Command\CreateStation;
use Gym\Domain\Command\DeleteExerciseToStation;
use Gym\Domain\Command\DeleteImage;
use Gym\Domain\Command\DeleteStation;
use Gym\Domain\Command\UpdateStation;
use Gym\Domain\Query\GetStation;
use Gym\Domain\Query\GetStationsForList;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StationController extends BaseController
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
        $stationsByTag = $this->queryBus->handle(
            new GetStationsForList()
        );

        return $this->renderForm('station/list.html.twig', [
            'stationsByTag' => $stationsByTag
        ]);
    }

    public function create(Request $request): Response
    {
        $form = $this->createForm(StationForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $photo = $this->commandBus->handle(
                new UploadFile($data[StationForm::IMAGE_UPLOAD_FIELD])
            );

            $stationId = $this->commandBus->handle(
                new CreateStation(
                    $data[StationForm::NAME_FIELD],
                    $photo,
                )
            );

            $this->commandBus->handle(
                new PutExercisesToStation(
                    $stationId,
                    $data[StationForm::EXERCISES_FIELD]
                )
            );

            return $this->redirectToRoute('station_read', ['id' => $stationId]);
        }

        return $this->renderForm('station/create.html.twig', [
            'form' => $form
        ]);
    }

    public function read(Request $request): Response
    {
        $station = $this->queryBus->handle(
            new GetStation($request->get('id'))
        );

        return $this->renderForm('station/read.html.twig', [
            'station' => $station
        ]);
    }


    public function update(Request $request): Response
    {
        $station = $this->queryBus->handle(
            new GetStation($request->get('id'))
        );

        $form = $this->createForm(StationForm::class, [
            StationForm::NAME_FIELD => $station['name'],
            StationForm::EXERCISES_FIELD => $station['exercise_ids'],
            StationForm::IMAGE_FIELD => $station['image'],
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $image = $station['image'];
            if (null !== $data[StationForm::IMAGE_UPLOAD_FIELD]) {
                $this->commandBus->handle(
                    new DeleteImage($image)
                );
                $image = $this->commandBus->handle(
                    new UploadFile($data[StationForm::IMAGE_UPLOAD_FIELD])
                );
            }

            $stationId = $this->commandBus->handle(
                new UpdateStation(
                    $request->get('id'),
                    $data[StationForm::NAME_FIELD],
                    $image,
                )
            );

            $this->commandBus->handle(
                new PutExercisesToStation(
                    $stationId,
                    $data[StationForm::EXERCISES_FIELD]
                )
            );

            return $this->redirectToRoute('station_read', ['id' => $stationId]);
        }

        return $this->renderForm('station/create.html.twig', [
            'form' => $form,
            'image' => $station['image']
        ]);
    }

    public function delete(Request $request): Response
    {
        $station = $this->queryBus->handle(
            new GetStation($request->get('id'))
        );

        $this->commandBus->handle(
            new DeleteImage($station['image'])
        );
        $this->commandBus->handle(
            new DeleteStation($station['id'])
        );
        $this->commandBus->handle(
            new DeleteExerciseToStation($station['id'])
        );

        return $this->redirectToRoute('station_list');
    }
}
