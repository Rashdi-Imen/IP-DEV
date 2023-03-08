<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Repository\OffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\Persistence\ManagerRegistry;


#[Route("/api/offres")]
class ApiOffreController extends AbstractController
{
    
    #[Route("/AllOffres", name: "list")]
   
    public function getOffres(OffreRepository $repo, SerializerInterface $serializer)
    {
        $offres = $repo->findAll();
    
        $json = $serializer->serialize($offres, 'json', ['groups' => "offres"]);

        return new Response($json);
    }
 
    #[Route("/Offre/{idOffre}", name: "offre")]
    public function OffreId($id, NormalizerInterface $normalizer, OffreRepository $repo)
    {
        $offre = $repo->find($id);
        $offreNormalises = $normalizer->normalize($offre, 'json', ['groups' => "offres"]);
        return new Response(json_encode($offreNormalises));
    }


    #[Route("/new", name: "addOffreJSON")]
    public function addOffreJSON(Request $request ,   NormalizerInterface $Normalizer , ManagerRegistry $doctrine,SerializerInterface $serializer): Response
    
    {

        $em = $this->getDoctrine()->getManager();
        $offre = new Offre();
        $offre->setNom($request->get('nom'));
        $offre->setDescription($request->get('description'));
        $offre->setPoints($request->get('points'));
        $offre->setImage($request->get('image'));
        $offre->setIdCategorie($request->get('idCategorie'));
        $em->persist($offre);
        $em->flush();

        $jsonContent = $Normalizer->normalize($offre, 'json', ['groups' => 'offres']);
        return new Response(json_encode($jsonContent));
       /* $content = $req->getContent() ;
        $em=$doctrine -> getManager() ; 
            $data = $serializer->deserialize($content , Offre::class,'json') ; 
            $em->persist($data);
            $em->flush();
            
        return new Response("Offre added successfully" .$data) ;*/
    }
    #[Route("/update/{id}", name: "updateOffreJSON",methods: [ 'PUT'])]
    public function updateOffreJSON(ManagerRegistry $doctrine , OffreRepository $repo,Request $request, $id, NormalizerInterface $Normalizer): Response
    {
        
        $em = $this->getDoctrine()->getManager();
        $offre = $em->getRepository(Offre::class)->find($id);
    //   var_dump($request);
    //   var_dump($request->get('nom'));
        $offre->setNom($request->get('nom'));
        $offre->setDescription($request->get('description'));
        $offre->setPoints($request->get('points'));
        $offre->setImage($request->get('image'));
        $em->flush() ;
        $OffreNormalises = $Normalizer->normalize($categorieOffre,'json' , ['groups'=>"offres"]) ;
        $json = json_encode($OffreNormalises) ;
        return new Response( "Offre updated successfully " . $json) ;

/*
        $em = $this->getDoctrine()->getManager();
        $offre = $em->getRepository(Offre::class)->find($id);
        $offre->setNom($request->get('nom'));
        $offre->setDescription($request->get('description'));
        $offre->setPoints($request->get('points'));
        $offre->setImage($request->get('image'));
        $em->flush();
        $jsonContent = $Normalizer->normalize($offre, 'json', ['groups' => "offres"]);
        return new Response("Offre updated successfully " . json_encode($jsonContent));
        */
    }
   

   
    #[Route("/delete/{id}", name: "deleteOffreJSON",methods: ['DELETE'])]
    public function deleteOffreJSON(ManagerRegistry $doctrine , OffreRepository $repo , NormalizerInterface $normalizer , $id): Response
    {
       // $em=$doctrine -> getManager() ; 
        $em = $this->getDoctrine()->getManager();
        $offre = $em->getRepository(Offre::class)->find($id);
        $em->remove($offre) ; 
        $em->flush() ;
        $OffreNormalises = $normalizer->normalize($offre,'json' , ['groups' => "offres"]) ;
        $json = json_encode($OffreNormalises) ;
        return new Response( "Offre deleted successfully " . $json) ;
        /*
        $em = $this->getDoctrine()->getManager();
        $offre = $em->getRepository(Student::class)->find($id); 
        $em->remove($offre);
        $em->flush();
        $jsonContent = $Normalizer->normalize($offre, 'json', ['groups' => 'offres']);
        return new Response("Offre deleted successfully " . json_encode($jsonContent));
    */
    }
}