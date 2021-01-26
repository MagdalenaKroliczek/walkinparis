<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreatewalkController extends AbstractController
{
    /**
     * @Route("/createwalk", name="createwalk")
     */
    public function index(): Response
    {
        return $this->render('createwalk/index.html.twig', [
            'controller_name' => 'CreatewalkController',
        ]);
    }
}
