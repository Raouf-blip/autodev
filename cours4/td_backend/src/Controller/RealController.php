<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RealController extends AbstractController
{
    #[Route('/real', name: 'app_real')]
    public function index(): Response
    {
        return $this->render('real/index.html.twig', [
            'controller_name' => 'RealController',
        ]);
    }
}
