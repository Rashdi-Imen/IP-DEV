<?php

namespace App\Controller;

use App\Entity\CategorieOffres;
use App\Repository\CategorieOffreRepository;
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


#[Route("/api/categorie")]
class ApiCategorieOffreController extends AbstractController
{
    
    #[Route("/AllCategorie", name: "listcategorie",methods: ['GET', 'POST'])]
   
    public function getCategorieOffre(CategorieOffreRepository   $repo, SerializerInterface $serializer)
    {
        $categorieOffres = $repo->findAll();
    
        $json = $serializer->serialize($categorieOffres, 'json', ['groups' => "categorieOffres"]);

        return new Response($json);
    }
 
    #[Route("/AllCategories", name: "categorie",methods: ['GET', 'POST'])]
    public function categorieOffreId($id, NormalizerInterface $normalizer, CategorieOffreRepository $repo)
    {
        $categorieOffre = $repo->find($id);
        $categorieOffreNormalises = $normalizer->normalize($categorieOffre, 'json', ['groups' => "categorieOffres"]);
        return new Response(json_encode($categorieOffreNormalises));
    }


    #[Route("/new", name: "addCategorieOffreJSON")]
    public function addCategorieOffreNormalisesJSON(Request $request,   NormalizerInterface $Normalizer , ManagerRegistry $doctrine,SerializerInterface $serializer): Response
    {

      /*  $em = $this->getDoctrine()->getManager();
        $categorieOffre = new CategorieOffres();
        $categorieOffre->setNom($request->get('nom'));
        $categorieOffre->setDescription($request->get('description'));*/
        $content = $request->getContent() ;
        $em=$doctrine -> getManager() ; 
            $data = $serializer->deserialize($content , CategorieOffres::class,'json') ; 
            $em->persist($data);
            $em->flush();
            
        return new Response("categorie added successfully" .$data) ;
      /*  $jsonContent = $Normalizer->normalize($categorieOffre, 'json', ['groups' => 'categorieOffres']);
        return new Response(json_encode($jsonContent));*/
    }

    #[Route("/update/{id}", name: "updateCategorieOffreJSON", methods: [ 'PUT'])]
    public function updateCategorieOffreJSON(ManagerRegistry $doctrine , CategorieOffreRepository $repo,Request $request, $id, NormalizerInterface $Normalizer): Response
    {                  
        
        
        $em = $this->getDoctrine()->getManager();
        $categorieOffre =$em->getRepository(CategorieOffres::class)->find($id);
        $categorieOffre->setNom($request->get('nom'));
        $categorieOffre->setDescription($request->get('description'));
        $em->flush() ;
        $CategorieOffreNormalises = $Normalizer->normalize($categorieOffre,'json' , ['groups'=>"categorieOffres"]) ;
        $json = json_encode($CategorieOffreNormalises) ;
        return new Response( "categorieOffre updated successfully" . $json) ;

    /*  $em = $this->getDoctrine()->getManager();
        $categorieOffre = $em->getRepository(categorieOffre::class)->find($id);
        $categorieOffre->setNom($request->get('nom'));
        $categorieOffre->setDescription($request->get('description'));
        $em->flush();

        $jsonContent = $Normalizer->normalize($categorieOffre, 'json', ['groups' => 'categorieOffres']);
        return new Response("CategorieOffre updated successfully " . json_encode($jsonContent));*/
    }
   

   
    #[Route("/delete/{id}", name: "deleteCategorieOffreJSON",methods: ['DELETE'])]
    public function deleteCategorieOffreJSON( ManagerRegistry $doctrine , CategorieOffreRepository $repo , NormalizerInterface $normalizer , $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $categorieOffre =$em->getRepository(CategorieOffres::class)->find($id);;
        $em->remove($categorieOffre) ; 
        $em->flush() ;
        $CategorieOffreNormalises = $normalizer->normalize($categorieOffre,'json' , ['groups'=>"categorieOffres"]) ;
        $json = json_encode($CategorieOffreNormalises) ;
        return new Response( "categorieOffre deleted successfully " . $json) ;
        
    }
}