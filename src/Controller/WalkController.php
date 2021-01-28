<?php

namespace App\Controller;

use App\Entity\Walk;
use App\Form\WalkFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
            /**
             * var doc symfony pour enregistrer une image
             * @see https://symfony.com/doc/current/controller/upload_file.html 
             */
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $originalFilename)));
                $newFilename = $safeFilename.'.'.$imageFile->guessExtension();
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
                $walk->setImage($newFilename);
            }

            $walk->setGuide($this->getUser());

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
