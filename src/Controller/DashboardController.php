<?php

namespace App\Controller;

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
        return $this->render('dashboard/guide.html.twig', [
            'controller_name' => 'DashboardController',
            'action_name' => 'showGuideDashboard',
        ]);
    }

    
    public function showVisitorDashboard(): Response
    {
        return $this->render('dashboard/visitor.html.twig', [
            'controller_name' => 'DashboardController',
            'action_name' => 'showVisitorDashboard',
        ]);
    }
}
