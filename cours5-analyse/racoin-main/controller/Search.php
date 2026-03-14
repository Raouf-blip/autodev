<?php

namespace controller;

use model\Annonce;
use model\Categorie;

class Search {

    public function show($twig, $menu, $chemin, $cat): void {
        $menu = [
            ['href' => $chemin,           'text' => 'Accueil'],
            ['href' => $chemin.'/search', 'text' => 'Recherche'],
        ];
        echo $twig->render('search.html.twig', [
            'breadcrumb' => $menu,
            'chemin'     => $chemin,
            'categories' => $cat,
        ]);
    }

    public function research($array, $twig, $menu, $chemin, $cat): void {
        $menu = [
            ['href' => $chemin,           'text' => 'Accueil'],
            ['href' => $chemin.'/search', 'text' => 'Résultats de la recherche'],
        ];

        $nospace_mc = str_replace(' ', '', $array['motclef']   ?? '');
        $nospace_cp = str_replace(' ', '', $array['codepostal'] ?? '');
        $categorie  = $array['categorie']  ?? '-----';
        $prix_min   = $array['prix-min']   ?? 'Min';
        $prix_max   = $array['prix-max']   ?? 'Max';

        $noFilter = $nospace_mc === ''
            && $nospace_cp === ''
            && in_array($categorie, ['Toutes catégories', '-----'])
            && $prix_min === 'Min'
            && in_array($prix_max, ['Max', 'nolimit']);

        if ($noFilter) {
            $annonce = Annonce::all();
        } else {
            $query = Annonce::query();

            if ($nospace_mc !== '') {
                $query->where('description', 'like', '%' . $array['motclef'] . '%');
            }
            if ($nospace_cp !== '') {
                $query->where('ville', '=', $array['codepostal']);
            }
            if (!in_array($categorie, ['Toutes catégories', '-----'])) {
                $categ = Categorie::select('id_categorie')->where('id_categorie', '=', $categorie)->first()->id_categorie;
                $query->where('id_categorie', '=', $categ);
            }
            if ($prix_min !== 'Min' && !in_array($prix_max, ['Max', 'nolimit'])) {
                $query->whereBetween('prix', [$prix_min, $prix_max]);
            } elseif (!in_array($prix_max, ['Max', 'nolimit'])) {
                $query->where('prix', '<=', $prix_max);
            } elseif ($prix_min !== 'Min') {
                $query->where('prix', '>=', $prix_min);
            }

            $annonce = $query->get();
        }

        echo $twig->render('index.html.twig', [
            'breadcrumb' => $menu,
            'chemin'     => $chemin,
            'annonces'   => $annonce,
            'categories' => $cat,
        ]);
    }
}
