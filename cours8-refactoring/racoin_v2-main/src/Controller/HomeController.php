<?php

namespace App\Controller;

use App\Model\Annonce;
use App\Model\Annonceur;
use App\Model\Photo;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Environment as Twig;

class HomeController
{
    public function __construct(
        private readonly Twig $twig,
        private readonly string $chemin
    ) {}

    public function index(Request $request, Response $response): Response
    {
        $categories = CategorieController::getAllCategories();
        $annonces = $this->getLatestAnnonces();

        $menu = [
            ['href' => $this->chemin, 'text' => 'Accueil'],
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

    public function exception(Request $request, Response $response): Response
    {
        throw new \Exception('Cette méthode déclenche une exception.');
    }

    private function getLatestAnnonces(): array
    {
        $annonces = Annonce::with('annonceur')
            ->orderBy('id_annonce', 'desc')
            ->take(12)
            ->get();

        $result = [];
        foreach ($annonces as $annonce) {
            $annonce->nb_photo = Photo::where('id_annonce', '=', $annonce->id_annonce)->count();
            $annonce->url_photo = $annonce->nb_photo > 0
                ? Photo::select('url_photo')->where('id_annonce', '=', $annonce->id_annonce)->first()->url_photo
                : '/img/noimg.png';
            $annonce->nom_annonceur = Annonceur::select('nom_annonceur')
                ->where('id_annonceur', '=', $annonce->id_annonceur)
                ->first()->nom_annonceur;
            $result[] = $annonce;
        }

        return $result;
    }
}
