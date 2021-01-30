<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;


class ProfileController extends AbstractController
{
    /**
     * @IsGranted({"ROLE_ADMIN","ROLE_GUIDE","ROLE_VISITOR"})
     * @Route("/profile", name="profile")
     */
    public function index(): Response
    {
        $account =$this->getUser();

        return $this->render('profile/index.html.twig', [
            'account' => $account,
        ]);
    }

/**
 * @Route("/modify-profile/{id}", name="modify_account")
 */
public function modifyAccount(int $id, Request $request): Response
{
    $entityManager = $this->getDoctrine()->getManager();

    $account = $entityManager->getRepository(Account::class)->find($id);
    $form = $this->createForm(ProfileFormType::class, $account);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid())
    {
        $entityManager->flush();
    }

    return $this->render("profile/profile-form.html.twig", [
        "form_title" => "Modifier mon profil",
        "form_product" => $form->createView(),
    ]);
}

/**
 * @Route("/delete-product/{id}", name="delete_account")
 */
public function deleteAccount(int $id): Response
{
    $entityManager = $this->getDoctrine()->getManager();
    $account = $entityManager->getRepository(Account::class)->find($id);
    $entityManager->remove($account);
    $entityManager->flush();

    return $this->redirectToRoute("accounts");
}


}
