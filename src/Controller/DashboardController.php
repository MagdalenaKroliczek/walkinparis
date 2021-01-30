<?php

namespace App\Controller;

use App\Entity\Walk;
use App\Repository\WalkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DashboardController extends AbstractController
{

        
    /**
     * @IsGranted({"ROLE_ADMIN","ROLE_GUIDE","ROLE_VISITOR"})
     * @Route("/dashboard", name="dashboard")
     */
    public function showDashboard(): Response
    {
        $account = $this->getUser();
        
        if ($account->isGuide()) {
            return $this->forward('App\Controller\DashboardController::showGuideDashboard', [
                'account'  => $account,
            ]);
        }

        if ($account->isVisitor()) {
            return $this->forward('App\Controller\DashboardController::showVisitorDashboard', [
                'account'  => $account,
            ]);
        }

        return $this->redirectToRoute('index');
    }


    public function showGuideDashboard(): Response
    {
        $guide = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();
        $walkRepository = $entityManager->getRepository(Walk::class);
        $walks = $walkRepository->findBy(['guide' => $guide], ["date" => "DESC"]);

        return $this->render('dashboard/guide.html.twig', [
            'walks' => $walks,
        ]);
    }

    
    public function showVisitorDashboard(): Response
    {
        $visitor = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();
        /**
         * @var WalkRepository 
         */
        $walkRepository = $entityManager->getRepository(Walk::class);
        $walks = $walkRepository->findByVisitors($visitor);

        return $this->render('dashboard/visitor.html.twig', [
            'walks' => $walks,
        ]);
    }
}
