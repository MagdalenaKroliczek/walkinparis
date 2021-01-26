<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactguideController extends AbstractController
{
    /**
     * @Route("/contactguide", name="contactguide")
     */
    public function index(): Response
    {
        return $this->render('contactguide/index.html.twig', [
            'controller_name' => 'ContactguideController',
        ]);
    }
}
