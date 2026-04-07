<?php

namespace Tests\Functional;

use PHPUnit\Framework\TestCase;

/**
 * Tests fonctionnels pour l'application Racoin.
 *
 * Ces tests utilisent un appel HTTP réel via le serveur intégré PHP
 * afin de rester découplés de l'implémentation interne (Slim 3 ou Slim 4).
 */
class RacoinTest extends TestCase
{
    private static string $baseUrl = 'http://localhost:8888';
    private static $serverProcess = null;

    public static function setUpBeforeClass(): void
    {
        $publicDir = realpath(__DIR__ . '/../../public');
        $descriptors = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];

        self::$serverProcess = proc_open(
            'php -S localhost:8888 -t ' . escapeshellarg($publicDir),
            $descriptors,
            $pipes,
            $publicDir
        );

        usleep(500000);
    }

    public static function tearDownAfterClass(): void
    {
        if (self::$serverProcess !== null) {
            proc_terminate(self::$serverProcess);
            proc_close(self::$serverProcess);
        }
    }

    private function httpGet(string $path): array
    {
        $ch = curl_init(self::$baseUrl . $path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $body = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ['status' => $statusCode, 'body' => $body];
    }

    private function httpPost(string $path, array $data): array
    {
        $ch = curl_init(self::$baseUrl . $path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $body = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ['status' => $statusCode, 'body' => $body];
    }

    /**
     * Teste que la page d'accueil est accessible et contient du contenu
     */
    public function testPageAccueil(): void
    {
        $response = $this->httpGet('/');

        $this->assertEquals(200, $response['status'],
            'La page d\'accueil devrait retourner un code 200');
        $this->assertNotEmpty($response['body'],
            'La page d\'accueil devrait retourner du contenu');
        $this->assertStringContainsString('RatCoin', $response['body'],
            'La page devrait contenir le titre "RatCoin"');
    }

    /**
     * Teste la consultation d'une annonce existante (annonce 1 des données d'import)
     */
    public function testConsulterAnnonce(): void
    {
        $response = $this->httpGet('/item/1');

        $this->assertEquals(200, $response['status'],
            'La page de l\'annonce devrait retourner un code 200');
        $this->assertNotEmpty($response['body'],
            'La page de l\'annonce devrait retourner du contenu');
        $this->assertStringContainsString('annonce', strtolower($response['body']),
            'La page devrait contenir des informations sur l\'annonce');
    }

    /**
     * Teste que le formulaire d'ajout d'annonce est accessible
     */
    public function testFormulaireAjout(): void
    {
        $response = $this->httpGet('/add');

        $this->assertEquals(200, $response['status'],
            'La page d\'ajout devrait retourner un code 200');
        $this->assertNotEmpty($response['body'],
            'La page d\'ajout devrait retourner du contenu');
    }

    /**
     * Teste la soumission d'une nouvelle annonce
     */
    public function testAjouterAnnonce(): void
    {
        $formData = [
            'nom' => 'Testeur PHPUnit',
            'email' => 'testeur@example.com',
            'phone' => '0612345678',
            'ville' => 'Paris',
            'departement' => '1',
            'categorie' => '1',
            'title' => 'Annonce de test PHPUnit',
            'description' => 'Description test PHPUnit',
            'price' => '150',
            'psw' => 'motdepasse',
            'confirm-psw' => 'motdepasse',
        ];

        $response = $this->httpPost('/add', $formData);

        $this->assertEquals(200, $response['status'],
            'L\'ajout d\'annonce devrait retourner un code 200');
        $this->assertStringNotContainsString('Veuillez entrer', $response['body'],
            'Il ne devrait pas y avoir d\'erreur de validation');
    }

    /**
     * Teste la page de recherche
     */
    public function testPageRecherche(): void
    {
        $response = $this->httpGet('/search');

        $this->assertEquals(200, $response['status'],
            'La page de recherche devrait retourner un code 200');
        $this->assertNotEmpty($response['body'],
            'La page de recherche devrait retourner du contenu');
    }

    /**
     * Teste la page d'une catégorie
     */
    public function testPageCategorie(): void
    {
        $response = $this->httpGet('/cat/1');

        $this->assertEquals(200, $response['status'],
            'La page de catégorie devrait retourner un code 200');
        $this->assertNotEmpty($response['body'],
            'La page de catégorie devrait retourner du contenu');
    }

    /**
     * Teste l'API annonces (JSON)
     */
    public function testApiAnnonces(): void
    {
        $response = $this->httpGet('/api/annonces');

        $this->assertEquals(200, $response['status'],
            'L\'API annonces devrait retourner un code 200');

        $body = $response['body'];
        $this->assertNotEmpty($body,
            'L\'API devrait retourner du contenu');

        $data = json_decode($body, true);
        $this->assertIsArray($data,
            'L\'API devrait retourner du JSON valide');
    }

    /**
     * Teste l'API détail d'une annonce
     */
    public function testApiAnnonceDetail(): void
    {
        $response = $this->httpGet('/api/annonce/1');

        $this->assertEquals(200, $response['status'],
            'L\'API annonce devrait retourner un code 200');

        $data = json_decode($response['body'], true);
        $this->assertNotNull($data,
            'L\'API devrait retourner du JSON valide');
    }

    /**
     * Teste la route /exception qui doit lever une exception
     */
    public function testRouteException(): void
    {
        $response = $this->httpGet('/exception');

        $this->assertNotEquals(200, $response['status'],
            'La route /exception devrait retourner une erreur (pas 200)');
    }
}
