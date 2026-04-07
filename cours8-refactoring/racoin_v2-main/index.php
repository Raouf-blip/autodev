<?php

use App\Controller\AnnonceController;
use App\Controller\AnnonceurController;
use App\Controller\ApiController;
use App\Controller\ApiKeyController;
use App\Controller\CategorieController;
use App\Controller\HomeController;
use App\Controller\SearchController;
use App\Database\Connection;
use App\Middleware\RequestLoggerMiddleware;
use App\Middleware\TrailingSlashMiddleware;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Slim\Factory\AppFactory;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require __DIR__ . '/vendor/autoload.php';

// Connexion à la base de données
Connection::create();

// Logger (Monolog)
$logger = new Logger('racoin');
$logger->pushHandler(new StreamHandler(__DIR__ . '/logs/app.log', Logger::DEBUG));
$logger->pushHandler(new StreamHandler(__DIR__ . '/logs/error.log', Logger::ERROR));

// Slim 4
$app = AppFactory::create();

// Twig
$loader = new FilesystemLoader(__DIR__ . '/template');
$twig = new Environment($loader);

// Chemin de base
$chemin = dirname($_SERVER['SCRIPT_NAME']);
if ($chemin === '/' || $chemin === '\\') {
    $chemin = '';
}

// Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    $_SESSION['formStarted'] = true;
}

if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = md5(uniqid((string) rand(), true));
    $_SESSION['token_time'] = time();
}

// Middlewares
$app->add(new RequestLoggerMiddleware($logger));
$app->add(new TrailingSlashMiddleware());
$app->addRoutingMiddleware();

// Gestion des erreurs avec logging
$errorMiddleware = $app->addErrorMiddleware(true, true, true, $logger);

// Controllers
$homeController = new HomeController($twig, $chemin);
$annonceController = new AnnonceController($twig, $chemin);
$searchController = new SearchController($twig, $chemin);
$categorieController = new CategorieController($twig, $chemin);
$annonceurController = new AnnonceurController($twig, $chemin);
$apiKeyController = new ApiKeyController($twig, $chemin);
$apiController = new ApiController($twig, $chemin);

// ===================== ROUTES WEB =====================

$app->get('/', [$homeController, 'index']);

$app->get('/exception', [$homeController, 'exception']);

$app->get('/item/{id}', [$annonceController, 'show']);

$app->get('/add', [$annonceController, 'addForm']);
$app->post('/add', [$annonceController, 'addSubmit']);

$app->get('/del/{id}', [$annonceController, 'deleteForm']);
$app->post('/del/{id}', [$annonceController, 'deleteSubmit']);

$app->get('/item/{id}/edit', [$annonceController, 'editForm']);
$app->post('/item/{id}/edit', [$annonceController, 'editPassword']);

$app->map(['GET', 'POST'], '/item/{id}/confirm', [$annonceController, 'editConfirm']);

$app->get('/search', [$searchController, 'showForm']);
$app->post('/search', [$searchController, 'search']);

$app->get('/annonceur/{id}', [$annonceurController, 'show']);

$app->get('/cat/{id}', [$categorieController, 'show']);

// ===================== ROUTES API =====================

$app->get('/api', [$apiController, 'documentation']);

$app->get('/api/annonce/{id}', [$apiController, 'getAnnonce']);
$app->get('/api/annonces', [$apiController, 'getAllAnnonces']);

$app->get('/api/categorie/{id}', [$apiController, 'getCategorie']);
$app->get('/api/categories', [$apiController, 'getAllCategories']);

$app->get('/api/key', [$apiKeyController, 'showForm']);
$app->post('/api/key', [$apiKeyController, 'generate']);

$app->run();
