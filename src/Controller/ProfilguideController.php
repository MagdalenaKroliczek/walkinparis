<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilguideController extends AbstractController
{
    /**
     * @Route("/profilguide", name="profilguide")
     */
    public function index(): Response
    {
        return $this->render('profilguide/index.html.twig', [
            'controller_name' => 'ProfilguideController',
        ]);
    }
}
