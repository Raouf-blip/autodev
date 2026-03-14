<?php
require 'vendor/autoload.php';

use db\connection;
use Slim\Factory\AppFactory;
use Slim\Exception\HttpNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use model\Annonce;
use model\Categorie;
use model\Annonceur;
use model\Departement;

// Connexion BDD
connection::createConn();

// Session & token CSRF
session_start();
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
    $_SESSION['token_time'] = time();
}

// Twig
$loader = new \Twig\Loader\FilesystemLoader('template');
$twig   = new \Twig\Environment($loader, ['autoescape' => 'html']);

// Chemin de base
$chemin = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');

// Helpers partagés
$cat = new \controller\getCategorie();
$dpt = new \controller\getDepartment();

// Slim 4
$app = AppFactory::create();
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

// Helper : capture le echo d'un contrôleur et l'écrit dans la Response
$render = function (Response $response, callable $callback): Response {
    ob_start();
    $callback();
    $html = ob_get_clean();
    $response->getBody()->write($html);
    return $response;
};

// ─── Routes HTML ────────────────────────────────────────────────────────────

$app->get('/', function (Request $request, Response $response) use ($twig, $chemin, $cat, $render) {
    return $render($response, function () use ($twig, $chemin, $cat) {
        $index = new \controller\index();
        $index->displayAllAnnonce($twig, [], $chemin, $cat->getCategories());
    });
});

$app->get('/item/{n}', function (Request $request, Response $response, array $args) use ($twig, $chemin, $cat, $render) {
    return $render($response, function () use ($twig, $chemin, $cat, $args) {
        $item = new \controller\item();
        $item->afficherItem($twig, [], $chemin, $args['n'], $cat->getCategories());
    });
});

$app->get('/add', function (Request $request, Response $response) use ($twig, $chemin, $cat, $dpt, $render) {
    return $render($response, function () use ($twig, $chemin, $cat, $dpt) {
        $ajout = new \controller\addItem();
        $ajout->addItemView($twig, [], $chemin, $cat->getCategories(), $dpt->getAllDepartments());
    });
});

$app->post('/add', function (Request $request, Response $response) use ($twig, $chemin, $render) {
    $allPostVars = (array) $request->getParsedBody();
    return $render($response, function () use ($twig, $chemin, $allPostVars) {
        $ajout = new \controller\addItem();
        $ajout->addNewItem($twig, [], $chemin, $allPostVars);
    });
});

$app->get('/item/{id}/edit', function (Request $request, Response $response, array $args) use ($twig, $chemin, $render) {
    return $render($response, function () use ($twig, $chemin, $args) {
        $item = new \controller\item();
        $item->modifyGet($twig, [], $chemin, $args['id']);
    });
});

$app->post('/item/{id}/edit', function (Request $request, Response $response, array $args) use ($twig, $chemin, $cat, $dpt, $render) {
    $allPostVars = (array) $request->getParsedBody();
    return $render($response, function () use ($twig, $chemin, $args, $allPostVars, $cat, $dpt) {
        $item = new \controller\item();
        $item->modifyPost($twig, [], $chemin, $args['id'], $cat->getCategories(), $dpt->getAllDepartments());
    });
});

$app->map(['GET', 'POST'], '/item/{id}/confirm', function (Request $request, Response $response, array $args) use ($twig, $chemin, $render) {
    $allPostVars = (array) $request->getParsedBody();
    return $render($response, function () use ($twig, $chemin, $args, $allPostVars) {
        $item = new \controller\item();
        $item->edit($twig, [], $chemin, $allPostVars, $args['id']);
    });
});

$app->get('/search', function (Request $request, Response $response) use ($twig, $chemin, $cat, $render) {
    return $render($response, function () use ($twig, $chemin, $cat) {
        $s = new \controller\Search();
        $s->show($twig, [], $chemin, $cat->getCategories());
    });
});

$app->post('/search', function (Request $request, Response $response) use ($twig, $chemin, $cat, $render) {
    $array = (array) $request->getParsedBody();
    return $render($response, function () use ($twig, $chemin, $cat, $array) {
        $s = new \controller\Search();
        $s->research($array, $twig, [], $chemin, $cat->getCategories());
    });
});

$app->get('/annonceur/{n}', function (Request $request, Response $response, array $args) use ($twig, $chemin, $cat, $render) {
    return $render($response, function () use ($twig, $chemin, $cat, $args) {
        $annonceur = new \controller\viewAnnonceur();
        $annonceur->afficherAnnonceur($twig, [], $chemin, $args['n'], $cat->getCategories());
    });
});

$app->get('/del/{n}', function (Request $request, Response $response, array $args) use ($twig, $chemin, $render) {
    return $render($response, function () use ($twig, $chemin, $args) {
        $item = new \controller\item();
        $item->supprimerItemGet($twig, [], $chemin, $args['n']);
    });
});

$app->post('/del/{n}', function (Request $request, Response $response, array $args) use ($twig, $chemin, $cat, $render) {
    return $render($response, function () use ($twig, $chemin, $cat, $args) {
        $item = new \controller\item();
        $item->supprimerItemPost($twig, [], $chemin, $args['n'], $cat->getCategories());
    });
});

$app->get('/cat/{n}', function (Request $request, Response $response, array $args) use ($twig, $chemin, $cat, $render) {
    return $render($response, function () use ($twig, $chemin, $cat, $args) {
        $categorie = new \controller\getCategorie();
        $categorie->displayCategorie($twig, [], $chemin, $cat->getCategories(), $args['n']);
    });
});

// ─── Routes API ─────────────────────────────────────────────────────────────

$app->get('/api', function (Request $request, Response $response) use ($twig, $chemin, $render) {
    return $render($response, function () use ($twig, $chemin) {
        $menu = [
            ['href' => $chemin,       'text' => 'Accueil'],
            ['href' => $chemin.'/api','text' => 'API'],
        ];
        echo $twig->render('api.html.twig', ['breadcrumb' => $menu, 'chemin' => $chemin]);
    });
});

$app->get('/api/annonce/{id}', function (Request $request, Response $response, array $args) {
    $annonceList = ['id_annonce', 'id_categorie as categorie', 'id_annonceur as annonceur',
                    'id_departement as departement', 'prix', 'date', 'titre', 'description', 'ville'];
    $return = Annonce::select($annonceList)->find($args['id']);

    if (!isset($return)) {
        throw new HttpNotFoundException($request);
    }

    $return->categorie   = Categorie::find($return->categorie);
    $return->annonceur   = Annonceur::select('email', 'nom_annonceur', 'telephone')->find($return->annonceur);
    $return->departement = Departement::select('id_departement', 'nom_departement')->find($return->departement);
    $return->links       = ['self' => ['href' => '/api/annonce/'.$return->id_annonce]];

    $response->getBody()->write($return->toJson());
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/api/annonces', function (Request $request, Response $response) {
    $annonceList = ['id_annonce', 'prix', 'titre', 'ville'];
    $annonces = Annonce::all($annonceList);
    foreach ($annonces as $ann) {
        $ann->links = ['self' => ['href' => '/api/annonce/'.$ann->id_annonce]];
    }
    $annonces->links = ['self' => ['href' => '/api/annonces']];
    $response->getBody()->write($annonces->toJson());
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/api/categorie/{id}', function (Request $request, Response $response, array $args) {
    $annonces = Annonce::select('id_annonce', 'prix', 'titre', 'ville')
        ->where('id_categorie', '=', $args['id'])->get();
    foreach ($annonces as $ann) {
        $ann->links = ['self' => ['href' => '/api/annonce/'.$ann->id_annonce]];
    }
    $c = Categorie::find($args['id']);
    $c->links    = ['self' => ['href' => '/api/categorie/'.$args['id']]];
    $c->annonces = $annonces;
    $response->getBody()->write($c->toJson());
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/api/categories', function (Request $request, Response $response) {
    $categories = Categorie::get();
    foreach ($categories as $cat) {
        $cat->links = ['self' => ['href' => '/api/categorie/'.$cat->id_categorie]];
    }
    $categories->links = ['self' => ['href' => '/api/categories']];
    $response->getBody()->write($categories->toJson());
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/api/key', function (Request $request, Response $response) use ($twig, $chemin, $cat, $render) {
    return $render($response, function () use ($twig, $chemin, $cat) {
        $kg = new \controller\KeyGenerator();
        $kg->show($twig, [], $chemin, $cat->getCategories());
    });
});

$app->post('/api/key', function (Request $request, Response $response) use ($twig, $chemin, $cat, $render) {
    $body = (array) $request->getParsedBody();
    $nom  = $body['nom'] ?? '';
    return $render($response, function () use ($twig, $chemin, $cat, $nom) {
        $kg = new \controller\KeyGenerator();
        $kg->generateKey($twig, [], $chemin, $cat->getCategories(), $nom);
    });
});

$app->run();
