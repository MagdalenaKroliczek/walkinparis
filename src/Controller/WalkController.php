<?php

namespace App\Controller;

use App\Entity\Walk;
use App\Form\WalkFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Form\Extension\Core\Type;
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
                $title = $form->get('title')->getData();
                $safeFilename = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // // this is needed to safely include the file name as part of the URL
                // $safeFilename = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $originalFilename)));
                // $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
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
     * @IsGranted({"ROLE_ADMIN","ROLE_GUIDE"})
     * @Route("/walk/update/{id}", name="walk_update")
     */
    public function modifyWalk(int $id, Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $walkRepository = $entityManager->getRepository(Walk::class);
        $walk = $walkRepository->findOneBy(['id' =>  $id]);

        if(!$walk) {
            $this->addFlash('warning_message','Balade non trouvée');
            return $this->redirectToRoute('dashboard');
        }

        $form = $this->createForm(WalkFormType::class, $walk);
        $form->add('image', Type\FileType::class, [
            'required' => false,
            'mapped' => false

        ]);
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

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($walk);
            $entityManager->flush();

            $this->addFlash('success_message','Balade modfiée');

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('walk/update.html.twig', [
            'walkForm' =>  $form->createView(),
        ]);
    }

    /**
     * @IsGranted({"ROLE_ADMIN","ROLE_GUIDE"})
     * @Route("/walk/delete/{id}", name="walk_delete")
     */
    public function deleteWalk(int $id, Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $walkRepository = $entityManager->getRepository(Walk::class);
        $walk = $walkRepository->findOneBy(['id' =>  $id]);

        if(!$walk) {
            $this->addFlash('warning_message','Balade non trouvée');
            return $this->redirectToRoute('dashboard');
        }
        
        if($walk->hasImage()) {
            /**
             * @see https://symfony.com/doc/4.4/components/filesystem.html#exists
             */
            $filesystem = new Filesystem();
            try {
                $imagePath = $this->getParameter('upload_directory').'/'. $walk->getImage();
                if($filesystem->exists( $imagePath)) {
                    $filesystem->remove($imagePath);
                }
            } catch (IOExceptionInterface $exception) {
                echo "An error occurred while creating your directory at ".$exception->getPath();
            }
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($walk);
        $entityManager->flush();
        
        $this->addFlash('success_message','Balade supprimée');

        return $this->redirectToRoute('dashboard');
    }

    /**
     * @Route("/walk/{id}", name="walk_show", requirements={"id"="\d+"})
     */
    public function showWalk(int $id): Response
    {
        // recupération de la walk ICI
        $walk = $this->getDoctrine()->getRepository(Walk::class)
            ->find($id)
            ;

        return $this->render('walk/index.html.twig',[
            'walk' => $walk
        ]);
    }

}
