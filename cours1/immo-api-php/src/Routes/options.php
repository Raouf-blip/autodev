<?php

namespace App\Routes;

use App\Controllers\OptionController;
use App\Middlewares\RequestValidations\CreateOption;

$app->group('/option', function ($app) {
    $app->post('[/]', [OptionController::class, 'create'])
        ->add(new CreateOption());

    $app->get('[/]', [OptionController::class, 'list']);

    $app->get('/{id}[/]', [OptionController::class, 'get']);

    $app->post('/{id}[/]', [OptionController::class, 'update'])
        ->add(new CreateOption());

    $app->delete('/{id}[/]', [OptionController::class, 'delete']);
});
