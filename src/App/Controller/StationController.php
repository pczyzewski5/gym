<?php

declare(strict_types=1);

namespace App\Controller;

use App\Command\UploadFile;
use App\CommandBus\CommandBus;
use App\Form\StationForm;
use App\QueryBus\QueryBus;
use Gym\Domain\Command\CreateExerciseToStation;
use Gym\Domain\Command\CreateStation;
use Gym\Domain\Query\GetStation;
use Gym\Domain\Query\GetStations;
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
        $stations = $this->queryBus->handle(
            new GetStations()
        );

        return $this->renderForm('station/list.html.twig', [
            'stations' => $stations
        ]);
    }

    public function create(Request $request): Response
    {
        $form = $this->createForm(StationForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $photo = $this->commandBus->handle(
                new UploadFile($data[StationForm::IMAGE_FIELD])
            );

            $stationId = $this->commandBus->handle(
                new CreateStation(
                    $data[StationForm::NAME_FIELD],
                    $photo,
                )
            );

            foreach ($data[StationForm::EXERCISES_FIELD] as $exerciseId) {
                $this->commandBus->handle(
                    new CreateExerciseToStation(
                        $exerciseId,
                        $stationId
                    )
                );
            }

            return $this->redirectToRoute('station_list');
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

    }

    public function delete(Request $request): Response
    {

    }
}
