<?php

namespace controller;

use model\Annonce;
use model\Photo;
use model\Annonceur;

class index {
    protected $annonce = array();

    public function getAll($chemin): void {
        $tmp    = Annonce::with("Annonceur")->orderBy('id_annonce', 'desc')->take(12)->get();
        $annonce = [];
        foreach ($tmp as $t) {
            $t->nb_photo = Photo::where("id_annonce", "=", $t->id_annonce)->count();
            if ($t->nb_photo > 0) {
                $t->url_photo = Photo::select("url_photo")
                    ->where("id_annonce", "=", $t->id_annonce)
                    ->first()->url_photo;
            } else {
                $t->url_photo = $chemin . '/img/noimg.png';
            }
            $t->nom_annonceur = Annonceur::select("nom_annonceur")
                ->where("id_annonceur", "=", $t->id_annonceur)
                ->first()->nom_annonceur;
            array_push($annonce, $t);
        }
        $this->annonce = $annonce;
    }

    public function displayAllAnnonce($twig, $menu, $chemin, $cat): void {
        $menu = [['href' => $chemin, 'text' => 'Accueil']];
        $this->getAll($chemin);
        echo $twig->render('index.html.twig', [
            'breadcrumb' => $menu,
            'chemin'     => $chemin,
            'categories' => $cat,
            'annonces'   => $this->annonce,
        ]);
    }
}
