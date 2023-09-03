<?php

namespace App\Controller;

use App\Entity\Espace;
use App\Repository\EspaceRepository;
use App\Repository\TypespaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PdfController extends AbstractController
{
    #[Route('/pdf', name: 'app_pdf')]
    public function index(): Response
    {
        return $this->render('pdf/index.html.twig', [
            'controller_name' => 'PdfController',
        ]);
    }
    #[Route('/listpdf', name: 'listpdf', methods: ['GET'])]
    public function pdf(EspaceRepository $repository, Pdf $pdf)
    {
        $espace = $repository->findAll();
        
        $html = $this->renderView('pdf/index.html.twig', [
            'espace' => $espace,
        ]);
    
        $pdfContent = $pdf->getOutputFromHtml($html);
    
        return new PdfResponse(
            $pdfContent,
            'mypdf.pdf',
            'application/pdf',
            'inline'
        );
    } 
    #[Route('/recherche', name: 'rechercheE')]
    function recherche(EspaceRepository $repository, Request $request): Response {
        $data = $request->get('search');
    
        // requête personnalisée pour rechercher tous les espaces avec une valeur similaire à la recherche
        $espace = $repository->createQueryBuilder('e')
            
            ->where('e.capacite LIKE :data')
            ->orWhere('e.nom LIKE :data')
            ->orWhere('e.id LIKE :data')
            ->orWhere('e.adresse LIKE :data')
            ->orWhere('e.etat LIKE :data')
            ->setParameter('data', '%'.$data.'%')
            ->getQuery()
            ->getResult();
    
        return $this->render('espace/index.html.twig', [
            'espaces' => $espace,
        ]);
    }
    #[Route('/rechercheuser', name: 'rechercheuser')]
    function rechercheuser(EspaceRepository $repository, Request $request): Response {
        $data = $request->get('search');
    
        // requête personnalisée pour rechercher tous les espaces avec une valeur similaire à la recherche
        $espace = $repository->createQueryBuilder('e')
            ->where('e.capacite LIKE :data')
            ->orWhere('e.nom LIKE :data')
            ->orWhere('e.id LIKE :data')
            ->orWhere('e.adresse LIKE :data')
            ->orWhere('e.etat LIKE :data')
            ->setParameter('data', '%'.$data.'%')
            ->getQuery()
            ->getResult();
    
        return $this->render('espace/user.html.twig', [
            'espaces' => $espace,
        ]);
    }
    #[Route('/statespace', name: 'statespace', methods: ['GET'])]
    public function stat(EntityManagerInterface $entityManager): Response
    {
        $espaces = $entityManager
            ->getRepository(Espace::class)
            ->findAll();
            $Disponible = 0;
            $NonDisponible = 0;
            $Espacess = 0;
            foreach ($espaces as $espacee) {
                if ($espacee->getEtat() == 'Disponible') {
                    $Disponible++;
                    $Espacess++;
                }
    
                if ($espacee->getEtat() == 'Non Disponible') {
                    $NonDisponible++;
                    $Espacess++;
                }
            }
            if ($Espacess > 0) {
                $Disponible = $Disponible * 100 / $Espacess;
                $NonDisponible = $NonDisponible * 100 / $Espacess;
            }

            
        return $this->render('espace/stat.html.twig', [
            'espaces' => $espaces,
            'Disponible' => $Disponible,
            'NonDisponible' => $NonDisponible
        ]);


 


    }
    #[Route('/recherchetypespace', name: 'recherchetypespace')]
    function recherchetypespace(TypespaceRepository $repository, Request $request): Response {
        $data = $request->get('search');
    
        // requête personnalisée pour rechercher tous les espaces avec une valeur similaire à la recherche
         $typespace = $repository->createQueryBuilder('t')
            ->where('t.typeespace LIKE :data')
            ->orWhere('t.id LIKE :data')
            ->setParameter('data', '%'.$data.'%')
            ->getQuery()
            ->getResult();
    
        return $this->render('typespace/index.html.twig', [
            'typespaces' => $typespace,
        ]);
    }
    
}
