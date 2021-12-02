<?php

namespace App\Controller;


use Doctrine\ORM\Id;
use App\Form\ContactType;
use App\Entity\FormContact;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FormContactRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\TextPart;


class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @return Response
     */
    public function contact(Request $request, MailerInterface $mailer, EntityManagerInterface $EntityManager): Response
    {
        $contact = new FormContact();

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($contact);
            // die();

            // on envoie dans la base
            $EntityManager->persist($contact);
            $EntityManager->flush();

            $mail = (new TemplatedEmail())
                ->from($contact->getEmail())
                ->to('maylhedge@gmail.com')
                ->subject('Time for Symfony Mailer!')
                ->htmlTemplate('emails/demande.html.twig')
                ->context([
                    'Nom' => $contact->getNom(),
                    'Prenom' => $contact->getPrenom(),
                    'Email' => $contact->getEmail(),
                    'Message' => $contact->getMessage()
                ]);
            //on envoie un email
            $mailer->send($mail);
        }
        //on redirige vers la vue 
        return $this->render('contact/contact.html.twig', [
            // 'controller_name' => 'ContactController',
            'formFormContact' => $form->createView()
        ]);
    }
}






// return $this->redirectToRoute('home');
// $form->handleRequest($request);
//     // $EntityManager = $this->getDoctrine()->getManager();
//     $EntityManager->persist($contact);
//     $EntityManager->flush();




// if ($form->isValidd() && $form->isSubmitte()) {
//         //On créé le mail 
//         $email = (new TemplatedEmail())
//             ->from('beteleheam.getu@colombbus.org')
//             ->to('bettygetu77@gmail.com')
//             ->subject('Time for Symfony Mailer!')
//             ->htmlTemplate('emails/demande.html.twig')
//             ->text([
//                 'nom' => $contact->get('nom')->getData(),
//                 'prenom' => $contact->get('prenom')->getData(),
//                 'email' => $contact->get('email')->getData(),
//                 'message' => $contact->get('message')->getData()
//             ]);
