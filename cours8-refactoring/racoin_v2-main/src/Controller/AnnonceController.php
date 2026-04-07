<?php

namespace App\Controller;

use App\Model\Annonce;
use App\Model\Annonceur;
use App\Model\Categorie;
use App\Model\Departement;
use App\Model\Photo;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Environment as Twig;

class AnnonceController
{
    public function __construct(
        private readonly Twig $twig,
        private readonly string $chemin
    ) {}

    public function show(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $annonce = Annonce::find($id);

        if (!$annonce) {
            $response->getBody()->write('404');
            return $response->withStatus(404);
        }

        $categories = CategorieController::getAllCategories();
        $annonceur = Annonceur::find($annonce->id_annonceur);
        $departement = Departement::find($annonce->id_departement);
        $photos = Photo::where('id_annonce', '=', $id)->get();

        $menu = [
            ['href' => $this->chemin, 'text' => 'Accueil'],
            ['href' => $this->chemin . '/cat/' . $annonce->id_categorie, 'text' => Categorie::find($annonce->id_categorie)?->nom_categorie],
            ['href' => $this->chemin . '/item/' . $id, 'text' => $annonce->titre],
        ];

        $html = $this->twig->render('item.html.twig', [
            'breadcrumb' => $menu,
            'chemin' => $this->chemin,
            'annonce' => $annonce,
            'annonceur' => $annonceur,
            'dep' => $departement->nom_departement,
            'photo' => $photos,
            'categories' => $categories,
        ]);

        $response->getBody()->write($html);
        return $response;
    }

    public function addForm(Request $request, Response $response): Response
    {
        $categories = CategorieController::getAllCategories();
        $departements = DepartementController::getAllDepartements();

        $menu = [
            ['href' => './index.php', 'text' => 'Accueil'],
        ];

        $html = $this->twig->render('add.html.twig', [
            'breadcrumb' => $menu,
            'chemin' => $this->chemin,
            'categories' => $categories,
            'departements' => $departements,
        ]);

        $response->getBody()->write($html);
        return $response;
    }

    public function addSubmit(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $menu = [['href' => './index.php', 'text' => 'Accueil']];

        $errors = $this->validateAnnonceData($data, true);

        if (!empty($errors)) {
            $html = $this->twig->render('add-error.html.twig', [
                'breadcrumb' => $menu,
                'chemin' => $this->chemin,
                'errors' => $errors,
            ]);
            $response->getBody()->write($html);
            return $response;
        }

        date_default_timezone_set('Europe/Paris');

        $annonceur = new Annonceur();
        $annonceur->email = htmlentities($data['email']);
        $annonceur->nom_annonceur = htmlentities($data['nom']);
        $annonceur->telephone = htmlentities($data['phone']);
        $annonceur->save();

        $annonce = new Annonce();
        $annonce->ville = htmlentities($data['ville']);
        $annonce->id_departement = $data['departement'];
        $annonce->prix = htmlentities($data['price']);
        $annonce->mdp = password_hash($data['psw'], PASSWORD_DEFAULT);
        $annonce->titre = htmlentities($data['title']);
        $annonce->description = htmlentities($data['description']);
        $annonce->id_categorie = $data['categorie'];
        $annonce->date = date('Y-m-d');
        $annonceur->annonces()->save($annonce);

        $html = $this->twig->render('add-confirm.html.twig', [
            'breadcrumb' => $menu,
            'chemin' => $this->chemin,
        ]);
        $response->getBody()->write($html);
        return $response;
    }

    public function deleteForm(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $annonce = Annonce::find($id);

        if (!$annonce) {
            $response->getBody()->write('404');
            return $response->withStatus(404);
        }

        $menu = [['href' => './index.php', 'text' => 'Accueil']];

        $html = $this->twig->render('delGet.html.twig', [
            'breadcrumb' => $menu,
            'chemin' => $this->chemin,
            'annonce' => $annonce,
        ]);

        $response->getBody()->write($html);
        return $response;
    }

    public function deleteSubmit(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $annonce = Annonce::find($id);
        $data = $request->getParsedBody();
        $categories = CategorieController::getAllCategories();
        $menu = [['href' => './index.php', 'text' => 'Accueil']];

        $success = false;
        if (password_verify($data['pass'] ?? '', $annonce->mdp)) {
            $success = true;
            Photo::where('id_annonce', '=', $id)->delete();
            $annonce->delete();
        }

        $html = $this->twig->render('delPost.html.twig', [
            'breadcrumb' => $menu,
            'chemin' => $this->chemin,
            'annonce' => $annonce,
            'pass' => $success,
            'categories' => $categories,
        ]);

        $response->getBody()->write($html);
        return $response;
    }

    public function editForm(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $annonce = Annonce::find($id);

        if (!$annonce) {
            $response->getBody()->write('404');
            return $response->withStatus(404);
        }

        $menu = [['href' => './index.php', 'text' => 'Accueil']];

        $html = $this->twig->render('modifyGet.html.twig', [
            'breadcrumb' => $menu,
            'chemin' => $this->chemin,
            'annonce' => $annonce,
        ]);

        $response->getBody()->write($html);
        return $response;
    }

    public function editPassword(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $annonce = Annonce::find($id);
        $annonceur = Annonceur::find($annonce->id_annonceur);
        $categories = CategorieController::getAllCategories();
        $departements = DepartementController::getAllDepartements();
        $categItem = Categorie::find($annonce->id_categorie)->nom_categorie;
        $dptItem = Departement::find($annonce->id_departement)->nom_departement;

        $menu = [['href' => './index.php', 'text' => 'Accueil']];
        $success = password_verify($data['pass'] ?? '', $annonce->mdp);

        $html = $this->twig->render('modifyPost.html.twig', [
            'breadcrumb' => $menu,
            'chemin' => $this->chemin,
            'annonce' => $annonce,
            'annonceur' => $annonceur,
            'pass' => $success,
            'categories' => $categories,
            'departements' => $departements,
            'dptItem' => $dptItem,
            'categItem' => $categItem,
        ]);

        $response->getBody()->write($html);
        return $response;
    }

    public function editConfirm(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $menu = [['href' => './index.php', 'text' => 'Accueil']];

        $errors = $this->validateAnnonceData($data, false);

        if (!empty($errors)) {
            $html = $this->twig->render('add-error.html.twig', [
                'breadcrumb' => $menu,
                'chemin' => $this->chemin,
                'errors' => $errors,
            ]);
            $response->getBody()->write($html);
            return $response;
        }

        date_default_timezone_set('Europe/Paris');

        $annonce = Annonce::find($id);
        $annonceur = Annonceur::find($annonce->id_annonceur);

        $annonceur->email = htmlentities($data['email']);
        $annonceur->nom_annonceur = htmlentities($data['nom']);
        $annonceur->telephone = htmlentities($data['phone']);
        $annonce->ville = htmlentities($data['ville']);
        $annonce->id_departement = $data['departement'];
        $annonce->prix = htmlentities($data['price']);
        $annonce->mdp = password_hash($data['psw'], PASSWORD_DEFAULT);
        $annonce->titre = htmlentities($data['title']);
        $annonce->description = htmlentities($data['description']);
        $annonce->id_categorie = $data['categorie'];
        $annonce->date = date('Y-m-d');
        $annonceur->save();
        $annonceur->annonces()->save($annonce);

        $html = $this->twig->render('modif-confirm.html.twig', [
            'breadcrumb' => $menu,
            'chemin' => $this->chemin,
        ]);
        $response->getBody()->write($html);
        return $response;
    }

    private function validateAnnonceData(array $data, bool $checkPassword): array
    {
        $errors = [];

        if (empty(trim($data['nom'] ?? ''))) {
            $errors[] = 'Veuillez entrer votre nom';
        }
        if (!filter_var($data['email'] ?? '', FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Veuillez entrer une adresse mail correcte';
        }
        if (empty(trim($data['phone'] ?? '')) || !is_numeric(trim($data['phone'] ?? ''))) {
            $errors[] = 'Veuillez entrer votre numéro de téléphone';
        }
        if (empty(trim($data['ville'] ?? ''))) {
            $errors[] = 'Veuillez entrer votre ville';
        }
        if (!is_numeric($data['departement'] ?? '')) {
            $errors[] = 'Veuillez choisir un département';
        }
        if (!is_numeric($data['categorie'] ?? '')) {
            $errors[] = 'Veuillez choisir une catégorie';
        }
        if (empty(trim($data['title'] ?? ''))) {
            $errors[] = 'Veuillez entrer un titre';
        }
        if (empty(trim($data['description'] ?? ''))) {
            $errors[] = 'Veuillez entrer une description';
        }
        if (empty(trim($data['price'] ?? '')) || !is_numeric(trim($data['price'] ?? ''))) {
            $errors[] = 'Veuillez entrer un prix';
        }

        if ($checkPassword) {
            $password = $data['psw'] ?? '';
            $confirm = $data['confirm-psw'] ?? '';
            if (empty($password) || empty($confirm) || $password !== $confirm) {
                $errors[] = 'Les mots de passes ne sont pas identiques';
            }
        }

        return $errors;
    }
}
