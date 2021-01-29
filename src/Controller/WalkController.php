<?php

namespace App\Controller;

use App\Entity\Walk;
use App\Form\WalkFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class WalkController extends AbstractController
{
    /**
     * @IsGranted({"ROLE_ADMIN","ROLE_GUIDE"})
     * @Route("/walk/create", name="walk_create")
     */
    public function createWalk(Request $request): Response
    {
        $walk = new Walk(); 
        $form = $this->createForm(WalkFormType::class, $walk);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // handle save walk
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($walk);
            $entityManager->flush();

            $this->addFlash('success_message','Balade ajoutée');

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('walk/create.html.twig', [
            'walkForm' =>  $form->createView(),
        ]);
    }

    /**
     * @Route("/walk/{id}", name="show_walk", requirements={"id"="\d+"})
     */
    public function showWalk(int $id): Response
    {
        return $this->render('walk/index.html.twig',[

        ]);
    }

}
