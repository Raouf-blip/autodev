<?php

use App\Config;

require('../vendor/autoload.php');

echo "Test Singleton Config\n\n";

$config1 = Config::getInstance();
echo "Config 1 - API Key: " . $config1->get('apiKey') . "\n";

$config2 = Config::getInstance();
echo "Config 2 - Debug Mode: " . ($config2->get('debug') ? 'True' : 'False') . "\n\n";

if ($config1 === $config2) {
    echo "SUCCESS: Both instances are identical.\n";
} else {
    echo "FAILURE: Both instances are different.\n";
}
