<?php

namespace App\Controller;

use App\Model\Annonce;
use App\Model\Annonceur;
use App\Model\Categorie;
use App\Model\Photo;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Environment as Twig;

class CategorieController
{
    public function __construct(
        private readonly Twig $twig,
        private readonly string $chemin
    ) {}

    public static function getAllCategories(): array
    {
        return Categorie::orderBy('nom_categorie')->get()->toArray();
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $categories = self::getAllCategories();
        $annonces = $this->getCategorieAnnonces($id);

        $menu = [
            ['href' => $this->chemin, 'text' => 'Accueil'],
            ['href' => $this->chemin . '/cat/' . $id, 'text' => Categorie::find($id)->nom_categorie],
        ];

        $html = $this->twig->render('index.html.twig', [
            'breadcrumb' => $menu,
            'chemin' => $this->chemin,
            'categories' => $categories,
            'annonces' => $annonces,
        ]);

        $response->getBody()->write($html);
        return $response;
    }

    private function getCategorieAnnonces(int $categorieId): array
    {
        $annonces = Annonce::with('annonceur')
            ->orderBy('id_annonce', 'desc')
            ->where('id_categorie', '=', $categorieId)
            ->get();

        $result = [];
        foreach ($annonces as $annonce) {
            $annonce->nb_photo = Photo::where('id_annonce', '=', $annonce->id_annonce)->count();
            $annonce->url_photo = $annonce->nb_photo > 0
                ? Photo::select('url_photo')->where('id_annonce', '=', $annonce->id_annonce)->first()->url_photo
                : $this->chemin . '/img/noimg.png';
            $annonce->nom_annonceur = Annonceur::select('nom_annonceur')
                ->where('id_annonceur', '=', $annonce->id_annonceur)
                ->first()->nom_annonceur;
            $result[] = $annonce;
        }

        return $result;
    }
}
