<?php

namespace App\Controller;

use App\Model\Annonce;
use App\Model\Categorie;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Environment as Twig;

class SearchController
{
    public function __construct(
        private readonly Twig $twig,
        private readonly string $chemin
    ) {}

    public function showForm(Request $request, Response $response): Response
    {
        $categories = CategorieController::getAllCategories();

        $menu = [
            ['href' => $this->chemin, 'text' => 'Accueil'],
            ['href' => $this->chemin . '/search', 'text' => 'Recherche'],
        ];

        $html = $this->twig->render('search.html.twig', [
            'breadcrumb' => $menu,
            'chemin' => $this->chemin,
            'categories' => $categories,
        ]);

        $response->getBody()->write($html);
        return $response;
    }

    public function search(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $categories = CategorieController::getAllCategories();

        $menu = [
            ['href' => $this->chemin, 'text' => 'Accueil'],
            ['href' => $this->chemin . '/search', 'text' => 'Résultats de la recherche'],
        ];

        $keyword = str_replace(' ', '', $data['motclef'] ?? '');
        $codePostal = str_replace(' ', '', $data['codepostal'] ?? '');
        $categorie = $data['categorie'] ?? '';
        $prixMin = $data['prix-min'] ?? 'Min';
        $prixMax = $data['prix-max'] ?? 'Max';

        $hasNoFilters = $keyword === ''
            && $codePostal === ''
            && ($categorie === 'Toutes catégories' || $categorie === '-----')
            && $prixMin === 'Min'
            && ($prixMax === 'Max' || $prixMax === 'nolimit');

        if ($hasNoFilters) {
            $annonces = Annonce::all();
        } else {
            $query = Annonce::query();

            if ($keyword !== '') {
                $query->where('description', 'like', '%' . $data['motclef'] . '%');
            }
            if ($codePostal !== '') {
                $query->where('ville', '=', $data['codepostal']);
            }
            if ($categorie !== 'Toutes catégories' && $categorie !== '-----') {
                $catId = Categorie::select('id_categorie')
                    ->where('id_categorie', '=', $categorie)
                    ->first()?->id_categorie;
                if ($catId) {
                    $query->where('id_categorie', '=', $catId);
                }
            }

            $this->applyPriceFilters($query, $prixMin, $prixMax);

            $annonces = $query->get();
        }

        $html = $this->twig->render('index.html.twig', [
            'breadcrumb' => $menu,
            'chemin' => $this->chemin,
            'annonces' => $annonces,
            'categories' => $categories,
        ]);

        $response->getBody()->write($html);
        return $response;
    }

    private function applyPriceFilters(mixed $query, string $prixMin, string $prixMax): void
    {
        if ($prixMin !== 'Min' && $prixMax !== 'Max') {
            if ($prixMax !== 'nolimit') {
                $query->whereBetween('prix', [$prixMin, $prixMax]);
            } else {
                $query->where('prix', '>=', $prixMin);
            }
        } elseif ($prixMax !== 'Max' && $prixMax !== 'nolimit') {
            $query->where('prix', '<=', $prixMax);
        } elseif ($prixMin !== 'Min') {
            $query->where('prix', '>=', $prixMin);
        }
    }
}
