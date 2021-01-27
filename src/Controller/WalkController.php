<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class WalkController extends AbstractController
{
    /**
     * @IsGranted({"ROLE_ADMIN","ROLE_GUIDE"})
     * @Route("/walk/create", name="walk_create")
     */
    public function createWalk(): Response
    {
        return $this->render('walk/create.html.twig', [
            'controller_name' => 'WalkController',
        ]);
    }

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
