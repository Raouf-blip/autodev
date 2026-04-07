<?php

namespace App\Controller;

use App\Model\ApiKey;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Environment as Twig;

class ApiKeyController
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
            ['href' => $this->chemin . '/api/key', 'text' => 'Clé API'],
        ];

        $html = $this->twig->render('key-generator.html.twig', [
            'breadcrumb' => $menu,
            'chemin' => $this->chemin,
            'categories' => $categories,
        ]);

        $response->getBody()->write($html);
        return $response;
    }

    public function generate(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $nom = $data['nom'] ?? '';
        $categories = CategorieController::getAllCategories();

        $menu = [
            ['href' => $this->chemin, 'text' => 'Accueil'],
            ['href' => $this->chemin . '/api/key', 'text' => 'Clé API'],
        ];

        if (trim(str_replace(' ', '', $nom)) === '') {
            $html = $this->twig->render('key-generator-error.html.twig', [
                'breadcrumb' => $menu,
                'chemin' => $this->chemin,
                'categories' => $categories,
            ]);
            $response->getBody()->write($html);
            return $response;
        }

        $key = uniqid();
        $apiKey = new ApiKey();
        $apiKey->id_apikey = $key;
        $apiKey->name_key = htmlentities($nom);
        $apiKey->save();

        $html = $this->twig->render('key-generator-result.html.twig', [
            'breadcrumb' => $menu,
            'chemin' => $this->chemin,
            'categories' => $categories,
            'key' => $key,
        ]);

        $response->getBody()->write($html);
        return $response;
    }
}
