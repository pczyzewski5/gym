<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\QueryBus\QueryBus;
use Gym\Domain\Query\GetMetricsHelper;
use Gym\Domain\Query\GetExerciseToStationInclNames;
use nadar\quill\Lexer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends BaseController
{
    private QueryBus $queryBus;
    private CommandBus $commandBus;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    public function index(Request $request): Response
    {
        $metricsHelper = $this->queryBus->handle(
            new GetMetricsHelper()
        );
        $exercisesToStations = $this->queryBus->handle(
            new GetExerciseToStationInclNames()
        );

        return $this->renderForm('index/index.html.twig', [
            'metricsHelper' => $metricsHelper,
            'exercisesToStations' => $exercisesToStations,
        ]);
    }

    public function quill(Request $request): Response
    {
        $content = $request->getContent();

        empty($content)
            ? $body = ''
            : $body = (new Lexer($content))->render();

        return new Response($body);
    }
}
