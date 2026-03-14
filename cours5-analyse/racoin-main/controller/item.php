<?php

namespace controller;

use model\Annonce;
use model\Annonceur;
use model\Departement;
use model\Photo;
use model\Categorie;

class item {

    public function __construct() {}

    public function afficherItem($twig, $menu, $chemin, $n, $cat): void {
        $this->annonce = Annonce::find($n);
        if (!isset($this->annonce)) {
            echo "404";
            return;
        }

        $menu = [
            ['href' => $chemin,                                                           'text' => 'Accueil'],
            ['href' => $chemin . "/cat/" . $this->annonce->id_categorie,
             'text' => Categorie::find($this->annonce->id_categorie)->nom_categorie],
            ['href' => $chemin . "/item/" . $n,                                           'text' => $this->annonce->titre],
        ];

        $this->annonceur  = Annonceur::find($this->annonce->id_annonceur);
        $this->departement = Departement::find($this->annonce->id_departement);
        $this->photo      = Photo::where('id_annonce', '=', $n)->get();

        echo $twig->render('item.html.twig', [
            'breadcrumb' => $menu,
            'chemin'     => $chemin,
            'annonce'    => $this->annonce,
            'annonceur'  => $this->annonceur,
            'dep'        => $this->departement->nom_departement,
            'photo'      => $this->photo,
            'categories' => $cat,
        ]);
    }

    public function supprimerItemGet($twig, $menu, $chemin, $n): void {
        $this->annonce = Annonce::find($n);
        if (!isset($this->annonce)) {
            echo "404";
            return;
        }
        echo $twig->render('delGet.html.twig', [
            'breadcrumb' => $menu,
            'chemin'     => $chemin,
            'annonce'    => $this->annonce,
        ]);
    }

    public function supprimerItemPost($twig, $menu, $chemin, $n, $cat): void {
        $this->annonce = Annonce::find($n);
        $reponse = false;
        if (password_verify($_POST["pass"], $this->annonce->mdp)) {
            $reponse = true;
            Photo::where('id_annonce', '=', $n)->delete();
            $this->annonce->delete();
        }

        echo $twig->render('delPost.html.twig', [
            'breadcrumb' => $menu,
            'chemin'     => $chemin,
            'annonce'    => $this->annonce,
            'pass'       => $reponse,
            'categories' => $cat,
        ]);
    }

    public function modifyGet($twig, $menu, $chemin, $id): void {
        $this->annonce = Annonce::find($id);
        if (!isset($this->annonce)) {
            echo "404";
            return;
        }
        echo $twig->render('modifyGet.html.twig', [
            'breadcrumb' => $menu,
            'chemin'     => $chemin,
            'annonce'    => $this->annonce,
        ]);
    }

    public function modifyPost($twig, $menu, $chemin, $n, $cat, $dpt): void {
        $this->annonce   = Annonce::find($n);
        $this->annonceur = Annonceur::find($this->annonce->id_annonceur);
        $this->categItem = Categorie::find($this->annonce->id_categorie)->nom_categorie;
        $this->dptItem   = Departement::find($this->annonce->id_departement)->nom_departement;

        $reponse = password_verify($_POST["pass"], $this->annonce->mdp);

        echo $twig->render('modifyPost.html.twig', [
            'breadcrumb'  => $menu,
            'chemin'      => $chemin,
            'annonce'     => $this->annonce,
            'annonceur'   => $this->annonceur,
            'pass'        => $reponse,
            'categories'  => $cat,
            'departements'=> $dpt,
            'dptItem'     => $this->dptItem,
            'categItem'   => $this->categItem,
        ]);
    }

    public function edit($twig, $menu, $chemin, $allPostVars, $id): void {
        date_default_timezone_set('Europe/Paris');

        $nom         = trim($allPostVars['nom']         ?? '');
        $email       = trim($allPostVars['email']       ?? '');
        $phone       = trim($allPostVars['phone']       ?? '');
        $ville       = trim($allPostVars['ville']       ?? '');
        $departement = trim($allPostVars['departement'] ?? '');
        $categorie   = trim($allPostVars['categorie']   ?? '');
        $title       = trim($allPostVars['title']       ?? '');
        $description = trim($allPostVars['description'] ?? '');
        $price       = trim($allPostVars['price']       ?? '');

        $errors = [];

        if (empty($nom))                                  $errors[] = 'Veuillez entrer votre nom';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))   $errors[] = 'Veuillez entrer une adresse mail correcte';
        if (empty($phone) || !is_numeric($phone))         $errors[] = 'Veuillez entrer votre numéro de téléphone';
        if (empty($ville))                                $errors[] = 'Veuillez entrer votre ville';
        if (!is_numeric($departement))                    $errors[] = 'Veuillez choisir un département';
        if (!is_numeric($categorie))                      $errors[] = 'Veuillez choisir une catégorie';
        if (empty($title))                                $errors[] = 'Veuillez entrer un titre';
        if (empty($description))                          $errors[] = 'Veuillez entrer une description';
        if (empty($price) || !is_numeric($price))         $errors[] = 'Veuillez entrer un prix';

        if (!empty($errors)) {
            echo $twig->render('add-error.html.twig', [
                'breadcrumb' => $menu,
                'chemin'     => $chemin,
                'errors'     => $errors,
            ]);
            return;
        }

        $this->annonce   = Annonce::find($id);
        $this->annonceur = Annonceur::find($this->annonce->id_annonceur);

        $this->annonceur->email        = htmlspecialchars($allPostVars['email'],       ENT_QUOTES);
        $this->annonceur->nom_annonceur = htmlspecialchars($allPostVars['nom'],         ENT_QUOTES);
        $this->annonceur->telephone    = htmlspecialchars($allPostVars['phone'],        ENT_QUOTES);
        $this->annonce->ville          = htmlspecialchars($allPostVars['ville'],        ENT_QUOTES);
        $this->annonce->id_departement = $allPostVars['departement'];
        $this->annonce->prix           = (float) $allPostVars['price'];
        $this->annonce->mdp            = password_hash($allPostVars['psw'], PASSWORD_DEFAULT);
        $this->annonce->titre          = htmlspecialchars($allPostVars['title'],        ENT_QUOTES);
        $this->annonce->description    = htmlspecialchars($allPostVars['description'],  ENT_QUOTES);
        $this->annonce->id_categorie   = $allPostVars['categorie'];
        $this->annonce->date           = date('Y-m-d');

        $this->annonceur->save();
        $this->annonceur->annonce()->save($this->annonce);

        echo $twig->render('modif-confirm.html.twig', [
            'breadcrumb' => $menu,
            'chemin'     => $chemin,
        ]);
    }
}
