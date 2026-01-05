<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;


use Slim\Psr7\Response;
use Slim\Routing\RouteContext;

class CorsMiddleware
{
    /**
     * Contrôle en partie du système de pagination
     *
     * @param Request  $request         représentation d'une requête HTTP
     * @param RequestHandler $handler   production d'une réponse HTTP
     *
     * @return Response                 réponse formatée en JSON
     *
     * @access public
     */
    public function __invoke(Request $request, RequestHandler $handler)
    {
        $routeContext = RouteContext::fromRequest($request);
        $routingResults = $routeContext->getRoutingResults();
        $methods = $routingResults->getAllowedMethods();
        $requestHeaders = $request->getHeaderLine('Access-Control-Request-Headers');

        $response = $handler->handle($request);

        $response = $response->withHeader('Access-Control-Allow-Origin', '*');
        $response = $response->withHeader('Access-Control-Allow-Methods', implode(',', $methods));
        $response = $response->withHeader('Access-Control-Allow-Headers', $requestHeaders);

        //Allow CORS requests with Authorization header
        $response = $response->withHeader('Access-Control-Allow-Credentials', 'true');

        return $response;
    }
}
