<?php

use App\Utils\JsonWriter;
use Lukasoppermann\Httpstatus\Httpstatuscodes as Status;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Routing\RouteContext;

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->forceContentType('application/json');

// Set the Not Found Handler 404
$errorMiddleware->setErrorHandler(
    HttpNotFoundException::class,
    function (Request $request, \Throwable $exception) {
        $response = new Response();
        $msg = 'URI non traitée par l\'application';

        return JsonWriter::error($response, Status::HTTP_NOT_FOUND, $msg, $exception);
    }
);

// Set the Not Allowed Handler 405
$errorMiddleware->setErrorHandler(
    HttpMethodNotAllowedException::class,
    function (Request $request, \Throwable $exception) {
        try {
            $routeContext = RouteContext::fromRequest($request);
            $routingResults = $routeContext->getRoutingResults();
            $allowed_methods = $routingResults->getAllowedMethods();
        } catch (\Exception $e) {
            $allowed_methods = null;
        }
        $response = new Response();
        //Appel du tableau avec les infos de la requête en cours
        $msg = 'Méthode non autorisé. Méthodes permises : ' . implode(',', $allowed_methods);

        return JsonWriter::error($response, Status::HTTP_METHOD_NOT_ALLOWED, $msg, $exception);
    }
);

// Set the Internal Server Error Exception 500
$errorMiddleware->setErrorHandler(
    HttpInternalServerErrorException::class,
    function (Request $request, \Throwable $exception) {
        $response = new Response();

        return JsonWriter::error($response, Status::HTTP_INTERNAL_SERVER_ERROR, 'Une erreur est survenue', $exception);
    }
);


$errorMiddleware->setDefaultErrorHandler(
    function (Request $request, \Throwable $exception) {
        $response = new Response();

        return JsonWriter::error($response, Status::HTTP_INTERNAL_SERVER_ERROR, 'Une erreur est survenue', $exception);
    }
);
