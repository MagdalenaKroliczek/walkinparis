<?php

namespace App\Controller;

use App\Entity\ContactUs;
use App\Form\ContactUsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactUsController extends AbstractController
{
    /**
     * @Route("/contact-us", name="contact_us")
     */
    public function index(Request $request, \Swift_Mailer $mailer): Response
    {
        $contact = new ContactUs();
        $contact->setSentAt(new \Datetime());
        
        $form = $this->createForm(ContactUsType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $message = (new \Swift_Message("[Formulaire] Demande de Contact !"))
                ->setFrom("contact@monsite.com")
                ->setTo($contact ->getEmail())
                ->setReplyTo("no-replay@monsite.com")
                ->setBody(
                    $this->renderView(
                        "emails/contact.html.twig",
                        ["contact" => $contact]  
                    ),
                    "text/html"
            );

            $mailer->send($message);

            $this->addFlash("succes_mail", "Le mail a bien été envoyé !");

        
        }


        return $this->render('contact_us/index.html.twig', [
            "formContactUs" => $form->createView()
        ]);
    }
}
