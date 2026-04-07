<?php

namespace App\Controller;

use App\Model\Annonce;
use App\Model\Annonceur;
use App\Model\Photo;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Environment as Twig;

class AnnonceurController
{
    public function __construct(
        private readonly Twig $twig,
        private readonly string $chemin
    ) {}

    public function show(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $annonceur = Annonceur::find($id);

        if (!$annonceur) {
            $response->getBody()->write('404');
            return $response->withStatus(404);
        }

        $categories = CategorieController::getAllCategories();
        $annonces = Annonce::where('id_annonceur', '=', $id)->get();

        $result = [];
        foreach ($annonces as $annonce) {
            $annonce->nb_photo = Photo::where('id_annonce', '=', $annonce->id_annonce)->count();
            $annonce->url_photo = $annonce->nb_photo > 0
                ? Photo::select('url_photo')->where('id_annonce', '=', $annonce->id_annonce)->first()->url_photo
                : $this->chemin . '/img/noimg.png';
            $result[] = $annonce;
        }

        $html = $this->twig->render('annonceur.html.twig', [
            'nom' => $annonceur,
            'chemin' => $this->chemin,
            'annonces' => $result,
            'categories' => $categories,
        ]);

        $response->getBody()->write($html);
        return $response;
    }
}
