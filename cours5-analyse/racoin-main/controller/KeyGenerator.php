<?php

namespace controller;

use model\ApiKey;

class KeyGenerator {

    private function buildMenu($chemin): array {
        return [
            ['href' => $chemin,       'text' => 'Accueil'],
            ['href' => $chemin.'/api','text' => 'API'],
        ];
    }

    public function show($twig, $menu, $chemin, $cat): void {
        echo $twig->render('key-generator.html.twig', [
            'breadcrumb' => $this->buildMenu($chemin),
            'chemin'     => $chemin,
            'categories' => $cat,
        ]);
    }

    public function generateKey($twig, $menu, $chemin, $cat, $nom): void {
        $nospace_nom = str_replace(' ', '', $nom);
        $breadcrumb  = $this->buildMenu($chemin);

        if ($nospace_nom === '') {
            echo $twig->render('key-generator-error.html.twig', [
                'breadcrumb' => $breadcrumb,
                'chemin'     => $chemin,
                'categories' => $cat,
            ]);
            return;
        }

        // Génération cryptographiquement sûre (32 hex chars)
        $key = bin2hex(random_bytes(16));

        $apikey           = new ApiKey();
        $apikey->id_apikey = $key;
        $apikey->name_key  = htmlspecialchars($nom, ENT_QUOTES);
        $apikey->save();

        echo $twig->render('key-generator-result.html.twig', [
            'breadcrumb' => $breadcrumb,
            'chemin'     => $chemin,
            'categories' => $cat,
            'key'        => $key,
        ]);
    }
}
