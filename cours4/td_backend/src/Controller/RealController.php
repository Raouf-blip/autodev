<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Realisator;

final class RealController extends AbstractController
{
    #[Route('/real', name: 'app_real')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        return $this->render('real/index.html.twig', [
            'controller_name' => 'RealController',
            'reals' => $entityManager->getRepository(Realisator::class)->findAll(),
        ]);
    }
}
