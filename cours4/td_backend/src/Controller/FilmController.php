<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Film;

final class FilmController extends AbstractController
{
    #[Route('/film', name: 'app_film')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        return $this->render('film/index.html.twig', [
            'controller_name' => 'FilmController',
            'films' => $entityManager->getRepository(Film::class)->findAll(),
        ]);
    }
}
