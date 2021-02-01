<?php

namespace App\Controller;

use App\Entity\Walk;
use App\Form\SearchFormType;
use App\Repository\WalkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(SearchFormType::class,);
        $form->handleRequest($request);
        $keywords = "";

        if($form->isSubmitted() && $form->isValid())
        {
            $keywords = $form->get("keywords")->getData();
        }
        
        $entityManager = $this->getDoctrine()->getManager();
        /** @var WalkRepository */
        $walkRepository = $entityManager->getRepository(Walk::class);
        $walks = $walkRepository->findByKeywords($keywords);

        return $this->render('homepage/index.html.twig', [
            'walks' => $walks,
            'searchForm' => $form->createView(),
            'keywords' => $keywords,
            'last_walks' => $walkRepository->getLastThreeWalks()
        ]);
    }
}
