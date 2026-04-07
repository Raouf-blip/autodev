<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Psr\Log\LoggerInterface;

class RequestLoggerMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly LoggerInterface $logger
    ) {}

    public function process(Request $request, Handler $handler): Response
    {
        $method = $request->getMethod();
        $uri = (string) $request->getUri();

        $this->logger->info("Requête entrante", [
            'method' => $method,
            'uri' => $uri,
        ]);

        $start = microtime(true);

        try {
            $response = $handler->handle($request);
        } catch (\Throwable $e) {
            $duration = round((microtime(true) - $start) * 1000, 2);
            $this->logger->error("Erreur lors du traitement de la requête", [
                'method' => $method,
                'uri' => $uri,
                'duration_ms' => $duration,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }

        $duration = round((microtime(true) - $start) * 1000, 2);
        $statusCode = $response->getStatusCode();

        $this->logger->info("Réponse envoyée", [
            'method' => $method,
            'uri' => $uri,
            'status' => $statusCode,
            'duration_ms' => $duration,
        ]);

        return $response;
    }
}
