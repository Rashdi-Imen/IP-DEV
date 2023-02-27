<?php

namespace App\Controller;

use App\Entity\FicheCollecte;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\FichesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;


#[Route('/api/fiche/collecte' )]
class ApiFicheCollecteController extends AbstractController
{
    #[Route('/', name: 'app_api_fiche_collecte_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('api_fiche_collecte/index.html.twig', [
            'controller_name' => 'ApiFicheCollecteController',
        ]);
    }

    
    #[Route("/allfiches", name: "list", methods: ['GET'])]

    public function getFiches(FichesRepository $repo , SerializerInterface $serializer )
    {
     
        return $this->json($repo->findAll(),200,[],['groups'=> "Fiches"]);
    }

    
    #[Route("/fiche/{id}", name: "fiche")]
    public function FicheId($id, NormalizerInterface $normalizer, FichesRepository $repo)
    {
        $fiche = $repo->find($id);
        $ficheNormalises = $normalizer->normalize($fiche, 'json', ['groups' => "Fiches"]);
        return new Response(json_encode($ficheNormalises));
    }

    #[Route("/addfiche/new", name: "addfiche", methods: ['POST'])]
    public function addfiche(Request $req,   NormalizerInterface $Normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $fiche = new FicheCollecte();
        $fiche->setPoids($req->get('poids'));
        $fiche->setIdDemandeCollecte($req->get('idDemandeCollecte'));
        $fiche->setIdUser($req->get('idUser'));
        $em->persist($fiche);
        $em->flush();

        $jsonContent = $Normalizer->normalize($fiche, 'json', ['groups' => 'Fiches']);
        return new Response(json_encode($jsonContent));
    }

}
