<?php

namespace App\Controller;

use App\Entity\DemandeCollecte;
use App\Form\DemandeCollecte1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/admin/demande/collecte')]
class AdminDemandeCollecteController extends AbstractController
{
    #[Route('/', name: 'app_admin_demande_collecte')]
    public function index(EntityManagerInterface $entityManager): Response
    {

        $demandeCollectes = $entityManager
            ->getRepository(DemandeCollecte::class)
            ->findAll();

        return $this->render('admin_demande_collecte/index.html.twig', [
            'controller_name' => 'AdminDemandeCollecteController','demande_collectes' => $demandeCollectes,
        ]);
    }


    #[Route('/{idDemandeCollecte}/accept', name: 'app_admin_demande_collecte_accept')]
    public function acceptDemande($idDemandeCollecte, Request $request, DemandeCollecte $demandeCollecte, EntityManagerInterface $entityManager)
    {
        
        $demandeCollecte = $entityManager->getRepository(DemandeCollecte::class)->find($idDemandeCollecte);

        if (!$demandeCollecte) {
            throw $this->createNotFoundException('No demande found for id '.$idDemandeCollecte);
        }

        $demandeCollecte->setEtatDemande('accepted');
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_demande_collecte', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{idDemandeCollecte}/reject', name: 'app_admin_demande_collecte_reject')]
    public function rejectDemande($idDemandeCollecte, Request $request, DemandeCollecte $demandeCollecte, EntityManagerInterface $entityManager)
    {
        
        $demandeCollecte = $entityManager->getRepository(DemandeCollecte::class)->find($idDemandeCollecte);

        if (!$demandeCollecte) {
            throw $this->createNotFoundException('No demande found for id '.$idDemandeCollecte);
        }

        $demandeCollecte->setEtatDemande('rejected');
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_demande_collecte', [], Response::HTTP_SEE_OTHER);
    }
}



    

