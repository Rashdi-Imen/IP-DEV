<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Form\OffreType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/offre')]
class OffreController extends AbstractController
{
    #[Route('/', name: 'app_offre_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $offres = $entityManager
            ->getRepository(Offre::class)
            ->findAll();

        return $this->render('offre/index.html.twig', [
            'offres' => $offres,
        ]);
    }

    #[Route('/new', name: 'app_offre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {    
        $offre = new Offre();
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();

            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$image->guessExtension();
    
                try {
                    $image->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // handle exception
                }
    
                $offre->setImage($newFilename);
            }
    
            $entityManager->persist($offre);
            $entityManager->flush();

            return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('offre/new.html.twig', [
            'offre' => $offre,
            'form' => $form,
        ]);
  
    }


    #[Route('/{idOffre}', name: 'app_offre_show', methods: ['GET'])]
    public function show(Offre $offre): Response
    {
        return $this->render('offre/show.html.twig', [
            'offre' => $offre,
        ]);
       
    }
    #[Route('/show/{idOffre}', name: 'app_details_show', methods: ['GET'])]
    public function showOffre(Offre $offre , EntityManagerInterface $entityManager): Response
    {   

        return $this->render('default/detailsOffre.html.twig', [
            'offre' => $offre,
        ]);
       
    }

    #[Route('/{idOffre}/edit', name: 'app_offre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Offre $offre, EntityManagerInterface $entityManager): Response
    {      $offre = new Offre();
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();

            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$image->guessExtension();
    
                try {
                    $image->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // handle exception
                }
    
                $offre->setImage($newFilename);
            }
    
            $entityManager->flush();


            return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('offre/edit.html.twig', [
            'offre' => $offre,
            'form' => $form,
        ]);
    }

    #[Route('/{idOffre}', name: 'app_offre_delete', methods: ['POST'])]
    public function delete(Request $request, Offre $offre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offre->getIdOffre(), $request->request->get('_token'))) {
            $entityManager->remove($offre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
    }
/*
    #[Route('/search', name:'searchOffre')]
    public function searchOffrex(Request $request,NormalizerInterface $Normalizer,OffreRepository $sr)
    { 
        $repository=$this->getDoctrine()->getRepository(Offre::class);
        $requestString=$request->get('nom');
        $offre=$sr->findOffreByName($requestString);
        $jsonContent=$Normalizer->normalize($offre);
        return new Response($retour);
    }*/

        

}
