<?php

namespace App\Controller;
use DateTimeImmutable;
use App\Entity\DemandeCollecte;
use App\Form\DemandeCollecte1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/demande/collecte')]
class DemandeCollecteController extends AbstractController
{
    #[Route('/', name: 'app_demande_collecte_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, PaginatorInterface $paginator , Request $request): Response
    {
        $demandeCollectes = $entityManager
            ->getRepository(DemandeCollecte::class)
            ->findAll();
            $demandeCollectes = $paginator->paginate($demandeCollectes,
            $request->query->getInt('page',1),3
    );

        return $this->render('demande_collecte/index.html.twig', [
            'demande_collectes' => $demandeCollectes,
        ]);
    }

    #[Route('/new', name: 'app_demande_collecte_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $demandeCollecte = new DemandeCollecte();
        $demandeCollecte-> setEtatDemande('en attente');

        $currentDate = DateTimeImmutable::createFromFormat('Y-m-d', date('Y-m-d'));

        $demandeCollecte-> setDateDemande($currentDate);
        $form = $this->createForm(DemandeCollecte1Type::class, $demandeCollecte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($demandeCollecte);
            $entityManager->flush();

            return $this->redirectToRoute('app_demande_collecte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('demande_collecte/new.html.twig', [
            'demande_collecte' => $demandeCollecte,
            'form' => $form,
        ]);
    }

    #[Route('/{idDemandeCollecte}', name: 'app_demande_collecte_show', methods: ['GET'])]
    public function show(DemandeCollecte $demandeCollecte): Response
    {
        return $this->render('demande_collecte/show.html.twig', [
            'demande_collecte' => $demandeCollecte,
        ]);
    }

    #[Route('/{idDemandeCollecte}/edit', name: 'app_demande_collecte_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DemandeCollecte $demandeCollecte, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DemandeCollecte1Type::class, $demandeCollecte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_demande_collecte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('demande_collecte/edit.html.twig', [
            'demande_collecte' => $demandeCollecte,
            'form' => $form,
        ]);
    }

    #[Route('/{idDemandeCollecte}', name: 'app_demande_collecte_delete', methods: ['POST'])]
    public function delete(Request $request, DemandeCollecte $demandeCollecte, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demandeCollecte->getIdDemandeCollecte(), $request->request->get('_token'))) {
            $entityManager->remove($demandeCollecte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_demande_collecte_index', [], Response::HTTP_SEE_OTHER);
    }
}
