<?php

namespace controller;

use model\Annonce;
use model\Annonceur;

class addItem {

    public function addItemView($twig, $menu, $chemin, $cat, $dpt): void {
        echo $twig->render('add.html.twig', [
            'breadcrumb'  => $menu,
            'chemin'      => $chemin,
            'categories'  => $cat,
            'departements'=> $dpt,
        ]);
    }

    public function addNewItem($twig, $menu, $chemin, $allPostVars): void {
        date_default_timezone_set('Europe/Paris');

        $nom              = trim($allPostVars['nom']          ?? '');
        $email            = trim($allPostVars['email']        ?? '');
        $phone            = trim($allPostVars['phone']        ?? '');
        $ville            = trim($allPostVars['ville']        ?? '');
        $departement      = trim($allPostVars['departement']  ?? '');
        $categorie        = trim($allPostVars['categorie']    ?? '');
        $title            = trim($allPostVars['title']        ?? '');
        $description      = trim($allPostVars['description']  ?? '');
        $price            = trim($allPostVars['price']        ?? '');
        $password         = trim($allPostVars['psw']          ?? '');
        $password_confirm = trim($allPostVars['confirm-psw']  ?? '');

        $errors = [];

        if (empty($nom))                                     $errors[] = 'Veuillez entrer votre nom';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))      $errors[] = 'Veuillez entrer une adresse mail correcte';
        if (empty($phone) || !is_numeric($phone))            $errors[] = 'Veuillez entrer votre numéro de téléphone';
        if (empty($ville))                                   $errors[] = 'Veuillez entrer votre ville';
        if (!is_numeric($departement))                       $errors[] = 'Veuillez choisir un département';
        if (!is_numeric($categorie))                         $errors[] = 'Veuillez choisir une catégorie';
        if (empty($title))                                   $errors[] = 'Veuillez entrer un titre';
        if (empty($description))                             $errors[] = 'Veuillez entrer une description';
        if (empty($price) || !is_numeric($price))            $errors[] = 'Veuillez entrer un prix';
        if (empty($password) || $password !== $password_confirm) $errors[] = 'Les mots de passe ne sont pas identiques';

        if (!empty($errors)) {
            echo $twig->render('add-error.html.twig', [
                'breadcrumb' => $menu,
                'chemin'     => $chemin,
                'errors'     => $errors,
            ]);
            return;
        }

        $annonce  = new Annonce();
        $annonceur = new Annonceur();

        $annonceur->email        = htmlspecialchars($allPostVars['email'], ENT_QUOTES);
        $annonceur->nom_annonceur = htmlspecialchars($allPostVars['nom'],   ENT_QUOTES);
        $annonceur->telephone    = htmlspecialchars($allPostVars['phone'],  ENT_QUOTES);

        $annonce->ville          = htmlspecialchars($allPostVars['ville'],        ENT_QUOTES);
        $annonce->id_departement = $allPostVars['departement'];
        $annonce->prix           = (float) $allPostVars['price'];
        $annonce->mdp            = password_hash($allPostVars['psw'], PASSWORD_DEFAULT);
        $annonce->titre          = htmlspecialchars($allPostVars['title'],        ENT_QUOTES);
        $annonce->description    = htmlspecialchars($allPostVars['description'],  ENT_QUOTES);
        $annonce->id_categorie   = $allPostVars['categorie'];
        $annonce->date           = date('Y-m-d');

        $annonceur->save();
        $annonceur->annonce()->save($annonce);

        echo $twig->render('add-confirm.html.twig', [
            'breadcrumb' => $menu,
            'chemin'     => $chemin,
        ]);
    }
}
