<?php

namespace App\Controller;

use App\Entity\Achat;
use App\Form\AchatType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OffreRepository;

#[Route('/achat/crud')]
class AchatCrudController extends AbstractController
{
    #[Route('/', name: 'app_achat_crud_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $achats = $entityManager
            ->getRepository(Achat::class)
            ->findAll();

        return $this->render('achat_crud/index.html.twig', [
            'achats' => $achats,
        ]);
    }

    #[Route('/new', name: 'app_achat_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $achat = new Achat();
        $form = $this->createForm(AchatType::class, $achat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($achat);
            $entityManager->flush();

            return $this->redirectToRoute('app_achat_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('achat_crud/new.html.twig', [
            'achat' => $achat,
            'form' => $form,
        ]);
    }

    #[Route('/{idAchat}', name: 'app_achat_crud_show', methods: ['GET'])]
    public function show(Achat $achat): Response
    {
        return $this->render('achat_crud/show.html.twig', [
            'achat' => $achat,
        ]);
    }

    #[Route('/{idAchat}/edit', name: 'app_achat_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Achat $achat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AchatType::class, $achat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_achat_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('achat_crud/edit.html.twig', [
            'achat' => $achat,
            'form' => $form,
        ]);
    }

    #[Route('/{idAchat}', name: 'app_achat_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Achat $achat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$achat->getIdAchat(), $request->request->get('_token'))) {
            $entityManager->remove($achat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_achat_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
