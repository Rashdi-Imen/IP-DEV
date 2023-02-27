<?php

namespace App\Controller;
use App\Repository\DemandeCollecteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class ApiDemandeCollecteController extends AbstractController
{
    #[Route('/api/demande/collecte', name: 'app_api_demande_collecte_index', methods: ['GET'])]
    public function index(DemandeCollecteRepository $rep): Response
    {
        $demandes = $rep->findAll();
        dd($demandes);

        return $this->render('api_demande_collecte/index.html.twig', [
            'controller_name' => 'ApiDemandeCollecteController',
        ]);
    }
}
