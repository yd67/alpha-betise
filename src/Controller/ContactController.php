<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request,\Swift_Mailer $Mailer): Response
    {
        $contactForm = $this->createForm(ContactType::class);
        $contactForm->handleRequest($request);

        // Envoie  De MAIL 
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $contact = $contactForm->getData();
            $message = (new \Swift_Message('Portfolio - demande de contact'))
                ->setFrom($contact['email'])
                ->setTo('snevy67100@gmail.com')
                ->setBody(
                    $this->renderView(
                        'contact/emailContact.html.twig', [
                            'nom' => $contact['nom'],
                            'prenom' => $contact['prenom'],
                            'email' => $contact['email'],
                            'message' => $contact['message'],
                        ]
                    ),
                    'text/html'
                )
            ;
            $Mailer->send($message);
            $this->addFlash(
                'success',
                'Votre message a bien été envoyé'
            );
          $this->redirectToRoute('contact');
            
        }
        return $this->render('contact/index.html.twig', [
            'contact' => $contactForm->createView(),
        ]);
    }
}
