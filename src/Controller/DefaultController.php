<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Offre;
use App\Form\OffreType;
use App\Form\SearchAllType;
use App\Entity\CategorieOffres;
use App\Form\CategorieOffres1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OffreRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//use Doctrine\ORM\Tools\Pagination\Paginator;
use Knp\Component\Pager\PaginatorInterface;
//use Knp\Component\Pager\Pagination\SlidingPagination;
//use Knp\Bundle\PaginatorBundle\Pagination\SlidingPaginationInterface;


class DefaultController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function homePage(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('/about', name: 'about')]
    public function aboutPage(): Response
    {
        return $this->render('default/about.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('/sevices', name: 'services')]
    public function servicesPage(): Response
    {
        return $this->render('default/services.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('/offres', name: 'offers')]
     public function allOffre(EntityManagerInterface $entityManager, Request $request, OffreRepository $offreRepo, PaginatorInterface $paginator ): Response  //PaginatorInterface $paginator
    { 
        $categorieOffres = $entityManager
        ->getRepository(CategorieOffres::class)
        ->findAll();

        $offres = $entityManager
        ->getRepository(Offre::class)
        ->findAll();
       
        $pagination = $paginator->paginate( $offres , $request->query->getInt('page', 1 ), 6);  
    
        return $this->render('default/offer.html.twig', [
            'offres' => $pagination,
            'categorieOffres' => $categorieOffres
        ]);
    }

        #[Route('/team', name: 'team')]
        public function teamPage(): Response
        {
            return $this->render('default/team.html.twig', [
                'controller_name' => 'DefaultController',
            ]);
        }

        #[Route('/contact', name: 'contact')]
        public function contactPage(): Response
        {
            return $this->render('default/contact.html.twig', [
                'controller_name' => 'DefaultController',
            ]);
        }

        #[Route("/offres/search", name:"offre_search")]
        public function search(Request $request , EntityManagerInterface $entityManager,PaginatorInterface $paginator )
        {   
            $categorieOffres = $entityManager
                ->getRepository(CategorieOffres::class)
                ->findAll();

            $searchQuery = $request->query->get('q');

            $offres = $this->getDoctrine()
                ->getRepository(Offre::class)
                ->createQueryBuilder('o')
                ->where('o.nom LIKE :query')
                ->orWhere('o.points LIKE :query')
                ->orWhere('o.description LIKE :query')
                ->setParameter('query', '%'.$searchQuery.'%')
                ->getQuery()
                ->getResult();

         
                $pagination = $paginator->paginate( $offres , $request->query->getInt('page', 1 ), 6);  

            return $this->render('offre/search.html.twig', [
               // 'offre' =>$pagination,
                'offres' => $pagination,
                'search_query' => $searchQuery,
                'categorieOffres' => $categorieOffres
            ]);
        }

        #[Route("/offres/filtre", name:"offres_index", methods:['GET'])]
        public function index(OffreRepository $offreRepository, CategorieOffreRepository $categorieOffreRepository, Request $request): Response
        {
            $categorieFilter = $request->query->get('category');
            $offres = $categorieFilter ? $offreRepository->findByCategorieName($categorieFilter) : $offreRepository->findAll();
            $categorieOffres = $categorieOffreRepository->findAll();
            
            return $this->render('offre/index.html.twig', [
                'offres' => $offres,
                'categorieOffres' => $categorieOffres,
            ]);
        }


}
    
 /*    

#[Route('/searchOffres', name: 'app_offre_search')]
    public function search(Request $request ,EntityManagerInterface $entityManager , PaginatorInterface $paginator ):Response
        {

            $categorieOffres = $entityManager
            ->getRepository(CategorieOffres::class)
            ->findAll();

            $offres = $entityManager
            ->getRepository(Offre::class)
            ->findAll();

            $searchTerm = $request->query->get('q');
            $queryBuilder = $entityManager->createQueryBuilder();
            $queryBuilder
                ->select('p')
                ->from(Offre::class, 'p')
                ->where('p.nom LIKE :searchTerm')
                ->orWhere('p.description LIKE :searchTerm')
                ->orWhere('p.points LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchTerm . '%');

            $offre = $queryBuilder->getQuery()->getResult();
            $pagination = $paginator->paginate( $offre , $request->query->getInt('page', 1), 3)->setUsedRoute('offers'); 

            return $this->render('default/offer.html.twig', [
                'offre' => $pagination,
             //   'offre' => $offre,
                'searchTerm' => $searchTerm,
                'offres' => $offres,
               'categorieOffres' => $categorieOffres
            ]);
        }

  



 */

  
   /* #[Route('/searchOffres', name: 'searchOffres')]
    public function listOffreSearch(Request $request, OffreRepository $offreRepo,EntityManagerInterface $entityManager)
    {
        //All of Offre
        $categorieOffres = $entityManager
        ->getRepository(CategorieOffres::class)
        ->findAll();

        $offres= $offreRepo->findAll();
        //search
        $searchForm = $this->createForm(SearchAllType::class);
        $searchForm->add("Recherche",SubmitType::class);
        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted()) {
            $nom= $searchForm['nom']->getData();
            $resulta = $offreRepo->searchNom($nom);
            return $this->render('default/offer.html.twig', array(
                "Offre" => $resulta,
                'categorie_offres' => $categorieOffres,
                "searchOffre" => $searchForm->createView()));
        }
        return $this->render('default/detailsOffre.html.twig', array(
            'offres' => $offres,
            'categorie_offres' => $categorieOffres,
            "searchOffre" => $searchForm->createView()));
    }*/