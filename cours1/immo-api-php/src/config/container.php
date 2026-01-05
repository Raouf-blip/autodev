<?php

use App\Utils\S3Client;

$container->set('settings', function () {
    return [
        'displayErrorDetails' => getenv('ENV_MODE') !== 'prod',
    ];
});

$container->set('s3', function ($c) {
    return new S3Client();
});
