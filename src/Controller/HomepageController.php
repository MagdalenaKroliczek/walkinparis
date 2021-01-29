<?php

namespace App\Controller;

use App\Entity\Walk;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $walkRepository = $entityManager->getRepository(Walk::class);
        $walks = $walkRepository->findAll();

        return $this->render('homepage/index.html.twig', [
            'walks' => $walks,
        ]);
    }
}
