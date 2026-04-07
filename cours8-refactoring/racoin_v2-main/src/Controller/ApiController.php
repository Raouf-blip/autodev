<?php

namespace App\Controller;

use App\Model\Annonce;
use App\Model\Annonceur;
use App\Model\Categorie;
use App\Model\Departement;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Environment as Twig;
use OpenApi\Attributes as OA;

#[OA\Info(title: "Racoin API", version: "1.0.0", description: "API de l'application Racoin - vente en ligne entre particuliers")]
class ApiController
{
    public function __construct(
        private readonly Twig $twig,
        private readonly string $chemin
    ) {}

    public function documentation(Request $request, Response $response): Response
    {
        $categories = CategorieController::getAllCategories();

        $menu = [
            ['href' => $this->chemin, 'text' => 'Accueil'],
            ['href' => $this->chemin . '/api', 'text' => 'Api'],
        ];

        $html = $this->twig->render('api.html.twig', [
            'breadcrumb' => $menu,
            'chemin' => $this->chemin,
        ]);

        $response->getBody()->write($html);
        return $response;
    }

    #[OA\Get(
        path: "/api/annonce/{id}",
        summary: "Récupérer une annonce par son ID",
        tags: ["Annonces"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Détail de l'annonce"),
            new OA\Response(response: 404, description: "Annonce non trouvée")
        ]
    )]
    public function getAnnonce(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $annonce = Annonce::select([
            'id_annonce',
            'id_categorie as categorie',
            'id_annonceur as annonceur',
            'id_departement as departement',
            'prix', 'date', 'titre', 'description', 'ville',
        ])->find($id);

        if (!$annonce) {
            $response->getBody()->write(json_encode(['error' => 'Not found']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $annonce->categorie = Categorie::find($annonce->categorie);
        $annonce->annonceur = Annonceur::select('email', 'nom_annonceur', 'telephone')
            ->find($annonce->annonceur);
        $annonce->departement = Departement::select('id_departement', 'nom_departement')
            ->find($annonce->departement);
        $annonce->links = ['self' => ['href' => '/api/annonce/' . $annonce->id_annonce]];

        $response->getBody()->write($annonce->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    }

    #[OA\Get(
        path: "/api/annonces",
        summary: "Lister toutes les annonces",
        tags: ["Annonces"],
        responses: [
            new OA\Response(response: 200, description: "Liste des annonces")
        ]
    )]
    public function getAllAnnonces(Request $request, Response $response): Response
    {
        $annonces = Annonce::all(['id_annonce', 'prix', 'titre', 'ville']);

        $items = $annonces->map(fn ($a) => array_merge($a->toArray(), [
            'links' => ['self' => ['href' => '/api/annonce/' . $a->id_annonce]],
        ]));

        $result = [
            'data' => $items,
            'links' => ['self' => ['href' => '/api/annonces']],
        ];

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');
    }

    #[OA\Get(
        path: "/api/categorie/{id}",
        summary: "Récupérer les annonces d'une catégorie",
        tags: ["Catégories"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Catégorie avec ses annonces")
        ]
    )]
    public function getCategorie(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];

        $annonces = Annonce::select('id_annonce', 'prix', 'titre', 'ville')
            ->where('id_categorie', '=', $id)
            ->get();

        foreach ($annonces as $annonce) {
            $annonce->links = ['self' => ['href' => '/api/annonce/' . $annonce->id_annonce]];
        }

        $categorie = Categorie::find($id);
        $categorie->links = ['self' => ['href' => '/api/categorie/' . $id]];
        $categorie->annonces = $annonces;

        $response->getBody()->write($categorie->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    }

    #[OA\Get(
        path: "/api/categories",
        summary: "Lister toutes les catégories",
        tags: ["Catégories"],
        responses: [
            new OA\Response(response: 200, description: "Liste des catégories")
        ]
    )]
    public function getAllCategories(Request $request, Response $response): Response
    {
        $categories = Categorie::get();

        $items = $categories->map(fn ($c) => array_merge($c->toArray(), [
            'links' => ['self' => ['href' => '/api/categorie/' . $c->id_categorie]],
        ]));

        $result = [
            'data' => $items,
            'links' => ['self' => ['href' => '/api/categories']],
        ];

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
