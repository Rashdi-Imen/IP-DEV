<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\User;
use App\Form\AchatType;
use App\Form\UserType;
use App\Form\OffreType;
use App\Repository\OffreRepository;
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
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Label\Font\NotoSans ;
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
    
        $message = (new Email())
            ->from('omarbenfathallah2021@gmail.com')
            ->to($user->getEmail())
            ->subject('Offre achetée avec succès')
            ->html($this->renderView('achat/achat_success.html.twig', ['offre' => $offre]));
    
        $mailer->send($message);
    
        return $this->render('achat/achat_success.html.twig',[
            'offre' => $offre,
        ]);
    }
    
    

    #[Route('/Sendqr/{idOffre}',name:'valide_achat')]
    public function someAction(MailerInterface $mailer , Offre $offre ,int $idOffre, EntityManagerInterface $entityManager,OffreRepository $offreRepo) : Response
    {
        $offre=$offreRepo->find($idOffre); 
        $qrString = "la promotion :" . $offre->getPoints()."%";
         $writer = new PngWriter();
 
         $qrCode = QrCode::create($qrString)
             ->setEncoding(new Encoding('UTF-8'))
             ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
             ->setSize(120)
             ->setMargin(0)
             ->setForegroundColor(new Color(0, 0, 0))
             ->setBackgroundColor(new Color(255, 255, 255));
         $logo = Logo::create('images/logo.png')
             ->setResizeToWidth(60);
         $label = Label::create('')->setFont(new NotoSans(8));
  
         $qrCodes = [];
         $qrCodes['img'] = $writer->write($qrCode, $logo)->getDataUri();
         $qrCodes['simple'] = $writer->write(
                                 $qrCode,
                                 null,
                                 $label->setText('Simple')
                             )->getDataUri(); 
         
         return $this->render('achat/achat_success.html.twig', [
             'offre' => $offre,
 
             'qrCodes' =>$qrCodes,
             
         
             
         ]);

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