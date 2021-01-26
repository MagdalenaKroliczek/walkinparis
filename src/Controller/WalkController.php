<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WalkController extends AbstractController
{
    /**
     * @Route("/walk/{id}", name="show_walk", requirements={"id"="\d+"})
     */
    public function showWalk(int $id): Response
    {
        return $this->render('walk/index.html.twig', [
            'controller_name' => 'WalkController',
        ]);
    }
}
