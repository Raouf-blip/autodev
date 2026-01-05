<?php

namespace App\Utils;

use Lukasoppermann\Httpstatus\Httpstatus as Status;
use Psr\Http\Message\ResponseInterface as Response;

class JsonWriter
{
    public static function success(Response $response, int $status, $response_data): Response
    {
        $response = $response->withStatus($status)
            ->withHeader('Content-Type', 'application/json');

        $response->getBody()->write(json_encode($response_data));

        return $response;
    }

    public static function error(Response $response, int $status, string $default_message, $e = null): Response
    {
        $msg = getenv('ENV_MODE') !== 'prod' && $e != null ? $e->getMessage() : $default_message;
        $response = $response->withStatus($status)
            ->withHeader('Content-Type', 'application/json');
        $httpStatus = new Status();
        $error_data = [
            'status' => $status,
            'type' => $httpStatus->getReasonPhrase($status),
            'message' => $msg,
        ];

        $response->getBody()->write(json_encode($error_data));

        return $response;
    }
}
