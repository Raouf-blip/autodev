<?php

namespace App\Middlewares;

use App\Utils\ParamValidation;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Respect\Validation\Validator;


use Slim\Psr7\Response;

class PaginationMiddleware
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
        $page = 1;
        $limit = 25;
        $order = "DESC";

        $reqPage = $request->getQueryParams()['page'] ?? $page;
        $reqLimit = $request->getQueryParams()['limit'] ?? $limit;
        $reqOrder = $request->getQueryParams()['order'] ?? $order;

        $validationPage = new ParamValidation();
        $validationPage->validate($reqPage, Validator::intVal()->positive(), 'page');
        $page = $validationPage->failed() ? $page : intval($reqPage);

        $validationLimit = new ParamValidation();
        $validationLimit->validate($reqLimit, Validator::intVal()->positive()->max(100), 'limit');
        $limit = $validationLimit->failed() ? $limit : intval($reqLimit);

        if (in_array(strtoupper($reqOrder), ['DESC','ASC'])) {
            $order = strtoupper($reqOrder);
        }

        $request = $request->withQueryParams([...$request->getQueryParams(), 'page' => $page, 'limit' => $limit, 'order' => $order]);
        $response = $handler->handle($request);

        return $response;
    }
}
