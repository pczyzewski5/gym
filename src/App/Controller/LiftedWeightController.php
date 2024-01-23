<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\QueryBus\QueryBus;
use Gym\Domain\Command\CreateLiftedWeight;
use Gym\Domain\Command\DeleteLiftedWeight;
use Gym\Domain\Query\GetDataForExerciseToStationMetrics;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class LiftedWeightController extends BaseController
{
    private QueryBus $queryBus;
    private CommandBus $commandBus;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    public function create(Request $request): Response
    {
        $payload = \json_decode($request->getContent(), true);

        $id = $this->commandBus->handle(
            new CreateLiftedWeight(
                Uuid::fromRfc4122($payload['training_id']),
                Uuid::fromRfc4122($payload['station_id']),
                Uuid::fromRfc4122($payload['exercise_id']),
                \intval($payload['repetition_count']),
                \intval($payload['kilogram_count']),
            )
        );

        return new Response($id, Response::HTTP_CREATED);
    }

    public function delete(Request $request): Response
    {
        $this->commandBus->handle(
            new DeleteLiftedWeight(
                Uuid::fromRfc4122($request->get('id'))
            )
        );

        return new Response(null,Response::HTTP_NO_CONTENT);
    }

    public function metrics(Request $request): Response
    {
        $data = $this->queryBus->handle(
            new GetDataForExerciseToStationMetrics(
                $request->get('exercise_id'),
                $request->get('station_id')
            )
        );

        return new Response(\json_encode($data));
    }
}
