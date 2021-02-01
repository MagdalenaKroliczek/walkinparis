<?php

namespace App\Controller;

use App\Form\AccountFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProfileController extends AbstractController
{
    /**
     * @IsGranted({"ROLE_ADMIN","ROLE_GUIDE","ROLE_VISITOR"})
     * @Route("/profile", name="profile")
     */
    public function index(Request $request): Response
    {
        $account =$this->getUser();
        $form = $this->createForm(AccountFormType::class, $account);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            /**
             * var doc symfony pour enregistrer une image
             * @see https://symfony.com/doc/current/controller/upload_file.html 
             */
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $title = $form->get('fullname')->getData();
                $safeFilename = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('upload_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $account->setImage($newFilename);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($account);
            $entityManager->flush();

            $this->addFlash('success_message','Profil mis à jour');
        }

        return $this->render('profile/index.html.twig', [
            'accountForm' => $form->createView(),
            'account' => $account,
        ]);
    }

    /**
     * @IsGranted({"ROLE_ADMIN","ROLE_GUIDE","ROLE_VISITOR"})
     * @Route("/profile/delete", name="profile_delete")
     */
    public function deleteAccount(): Response
    {
        // faire suppression de profile & balade 

        return $this->redirectToRoute("index");
    }

}
