<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Slim\Psr7\Response as SlimResponse;

class TrailingSlashMiddleware implements MiddlewareInterface
{
    public function process(Request $request, Handler $handler): Response
    {
        $uri = $request->getUri();
        $path = $uri->getPath();

        if ($path !== '/' && str_ends_with($path, '/')) {
            $uri = $uri->withPath(rtrim($path, '/'));

            if ($request->getMethod() === 'GET') {
                $response = new SlimResponse();
                return $response
                    ->withHeader('Location', (string) $uri)
                    ->withStatus(301);
            }

            $request = $request->withUri($uri);
        }

        return $handler->handle($request);
    }
}
