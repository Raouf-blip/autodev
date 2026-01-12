<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class MyExtension extends AbstractExtension
{
    public function getName(): string
    {
        return 'my-extension';
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getEnvironmentVariable', [$this, 'getEnvironmentVariable']),
            new TwigFunction('getViteAssets', [$this, 'getViteAssets']),
        ];
    }

    public function getEnvironmentVariable(string $varName): ?string
    {
        return $_ENV[$varName] ?? null;
    }

    public function manifest()
    {
        $json_file_path = __DIR__ . '/../../public/build/.vite/manifest.json';
        if (file_exists($json_file_path)) {
            $json_data = file_get_contents($json_file_path);

            return json_decode($json_data, true);
        }

        return '';
    }

    public function getViteAssets(): string
    {
        if ($_ENV['ENV'] === 'prod') {
            $manifest = $this->manifest();
            if (!$manifest) {
                return '';
            }
            // Récupérer l'entrée "main.js" dans le manifest
            $entry = $manifest['main.js'] ?? null;
            if (!$entry) {
                return '<!-- Entry point "main.js" introuvable dans le manifest -->';
            }

            $html = '';

            // 1. Charger les fichiers CSS
            if (isset($entry['css'])) {
                foreach ($entry['css'] as $cssFile) {
                    $html .= sprintf('<link rel="stylesheet" href="/build/%s">', $cssFile) . "\n    ";
                }
            }

            // 2. Charger le fichier JavaScript
            $html .= sprintf('<script type="module" src="/build/%s"></script>', $entry['file']);

            return $html;
        } else {
            return <<<HTML
                    <script type="module" src="http://localhost:3000/@vite/client"></script>
                        <script type="module" src="http://localhost:3000/main.js"></script>
                    HTML;
        }
    }
}
