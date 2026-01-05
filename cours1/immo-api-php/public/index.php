<?php

use App\Middlewares\CorsMiddleware;
use DI\Container;
use Dotenv\Dotenv;
use App\Utils\DBConnection;
use App\Utils\JsonWriter;
use Slim\Factory\AppFactory;
use Dotenv\Exception\ValidationException;
use Lukasoppermann\Httpstatus\Httpstatuscodes as Status;
use Slim\Exception\HttpNotFoundException;

require __DIR__ . '/../vendor/autoload.php';

// Check env variables
try {
  $dotenv = Dotenv::createUnsafeImmutable("..");
  $dotenv->safeLoad();
  $dotenv->required([ 'MYSQL_HOST', 'MYSQL_DATABASE', 'MYSQL_USER', 'MYSQL_PASSWORD'])->notEmpty();
} catch (ValidationException $e) {
  http_response_code(Status::HTTP_INTERNAL_SERVER_ERROR);
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode(['type' => "Internal server error", "status" => Status::HTTP_INTERNAL_SERVER_ERROR, 'message' => $e->getMessage()]);
  exit();
}

// Init Database
DBConnection::init();

// Instantiate PHP-DI Container & Slim App
$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();

require_once __DIR__ . '/../src/config/container.php';
require_once __DIR__ . '/../src/config/error.php';

$app->get('/', function ($request, $response, $args) {
  return JsonWriter::success($response, Status::HTTP_OK, ['message'=>'Hello World!']);
});

$app->options('/{routes:.+}', function ($request, $response, $args) {
  return $response;
});

$app->addBodyParsingMiddleware();
$app->add(new CorsMiddleware());
$app->addRoutingMiddleware();

$app->group('/api', function ($app) {
    require_once __DIR__ . '/../src/Routes/properties.php';
    require_once __DIR__ . '/../src/Routes/options.php';
});

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
  throw new HttpNotFoundException($request);
});

$app->run();