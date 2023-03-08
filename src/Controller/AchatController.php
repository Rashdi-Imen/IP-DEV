<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\User;
use App\Form\AchatType;
use App\Form\UserType;
use App\Form\OffreType;
use App\Entity\Achat;   
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Swift_Attachment;
use Swift_Message;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Encoding\Encoding;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Endroid\QrCode\Builder\BuilderInterface;

class AchatController extends AbstractController
{
    #[Route('/achat/{idOffre}', name: 'app_achat')]
    public function index(EntityManagerInterface $entityManager , Offre $offre): Response
    {
        return $this->render('achat/index.html.twig', [
            'controller_name' => 'AchatController',
            'offre' => $offre
           
        ]);
    }


    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }


    #[Route('/mail/{idOffre}', name: 'valider_achat')]
    public function acheterOffre(MailerInterface $mailer, Offre $offre): Response
    {
        $user = $this->getUser();
    
        $achat = new Achat();  
        $achat->setIdOffre($offre);
        $achat->setIdUser($user);
        $achat->setDateAchat(new \DateTime());
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($achat);
        $entityManager->flush();
    
        $message = (new \Symfony\Component\Mime\Email())
            ->from('your_email@gmail.com')
            ->to($user->getEmail())
            ->subject('Offre achetée avec succès')
            ->html($this->renderView('achat/achat_success.html.twig', ['offre' => $offre]));
    
        $mailer->send($message);
    
        return $this->render('achat/achat_success.html.twig',[
            'offre' => $offre,
        ]);
    }
    
    

    #[Route('/Sendmail/{idOffre}',name:'valide_achat')]
    public function someAction(MailerInterface $mailer , Offre $offre , EntityManagerInterface $entityManager) : Response
    {
        // Render the detailsOffre.html.twig template and store its contents in a variable
        $detailsOffreTemplateContents = $this->renderView('default/detailsOffre.html.twig', [
            'offre' => $offre,
        ]);

        // Send the email to the user
      //  $userId = 10;
        $userEmail = 'omarbenfathallah782@gmail.com';

        $email = (new Email())
            ->to($userEmail)
            ->subject('Details Offre')
            ->html($detailsOffreTemplateContents);

        $mailer->send($email);

      //  return new Response('Email sent successfully');

        // ...
       /* return $this->redirectToRoute('offers', ['idOffre' => $offre->getIdOffre()]);
        return $this->redirectToRoute('app_details_show', [], Response::HTTP_SEE_OTHER);*/
        return $this->redirectToRoute('app_details_show', ['idOffre' => $offre->getIdOffre()]);
        

    }
    
}


 /*
 
     private function getTestUser(): User
    {
        $user = new User();
        $user->setUsername('test_user');
        $user->setEmail('test_user@example.com');
        // ... set other properties as needed
        return $user;
    }
 
 $achat = new Achat();  
    $achat->setIdOffre($offre);
    $achat->setIdUser(10);
    $achat->setDateAchat(new \DateTime());
    $entityManager = $this->getDoctrine()->getManager();
    
    if($userSolde >= $offre->getPoints()) {
        $entityManager->persist($achat);
        $entityManager->flush();*/