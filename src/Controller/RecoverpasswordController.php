<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecoverpasswordController extends AbstractController
{
    /**
     * @Route("/recoverpassword", name="recoverpassword")
     */
    public function index(): Response
    {
        return $this->render('recoverpassword/index.html.twig', [
            'controller_name' => 'RecoverpasswordController',
        ]);
    }
}
