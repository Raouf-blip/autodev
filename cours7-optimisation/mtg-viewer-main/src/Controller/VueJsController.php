<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class VueJsController extends AbstractController
{
    /**
     * This route serve the Vue.js APP and
     * is automatically called when no other routes matched
     *
     * @return Response
     *
     * @see config/routes.yaml
     */
    public function __invoke(): Response
    {
        return $this->render('base.html.twig');
    }
}
