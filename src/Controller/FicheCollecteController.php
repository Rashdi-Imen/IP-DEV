<?php

namespace App\Controller;
use App\Entity\DemandeCollecte;
use App\Entity\Poubelle;
use App\Entity\FicheCollecte;
use App\Entity\User;
use App\Form\FicheCollecte1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
#[Route('/fiche/collecte')]
class FicheCollecteController extends AbstractController
{
    #[Route('/', name: 'app_fiche_collecte_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager , PaginatorInterface $paginator , Request $request): Response
    {
        $ficheCollectes = $entityManager
            ->getRepository(FicheCollecte::class)
            ->findAll();

            $ficheCollectes = $paginator->paginate($ficheCollectes,
            $request->query->getInt('page',1),5
    );

        return $this->render('fiche_collecte/index.html.twig', [
            'fiche_collectes' => $ficheCollectes,
        ]);
    }

    #[Route('/new', name: 'app_fiche_collecte_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ficheCollecte = new FicheCollecte();
        $form = $this->createForm(FicheCollecte1Type::class, $ficheCollecte);
        $form->handleRequest($request);

       

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ficheCollecte);
            $entityManager->flush();

           $demande=$ficheCollecte->getIdDemandeCollecte();
           $poubelle=$demande->getIdPoubelle();
   
           $type=$poubelle->getIdType();
   
           $poids_dechets = $ficheCollecte->getPoids() - $type->getPoidsVide();
           $points = $poids_dechets * $type->getMultiplicateur();

        

$user = $ficheCollecte->getIdUser();
            $user->setSolde($user->getSolde() + intval($points));
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_fiche_collecte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fiche_collecte/new.html.twig', [
            'fiche_collecte' => $ficheCollecte,
            'form' => $form,
        ]);
    }

    #[Route('/{idFicheCollecte}', name: 'app_fiche_collecte_show', methods: ['GET'])]
    public function show(FicheCollecte $ficheCollecte): Response
    {
        return $this->render('fiche_collecte/show.html.twig', [
            'fiche_collecte' => $ficheCollecte,
        ]);
    }

    #[Route('/{idFicheCollecte}/edit', name: 'app_fiche_collecte_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FicheCollecte $ficheCollecte, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FicheCollecte1Type::class, $ficheCollecte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_fiche_collecte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fiche_collecte/edit.html.twig', [
            'fiche_collecte' => $ficheCollecte,
            'form' => $form,
        ]);
    }

    #[Route('/{idFicheCollecte}', name: 'app_fiche_collecte_delete', methods: ['POST'])]
    public function delete(Request $request, FicheCollecte $ficheCollecte, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ficheCollecte->getIdFicheCollecte(), $request->request->get('_token'))) {
            $entityManager->remove($ficheCollecte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_fiche_collecte_index', [], Response::HTTP_SEE_OTHER);
    }
}
