<?php

namespace App\Controller;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;

use App\Entity\Espace;
use App\Form\EspaceType;
use App\Repository\EspaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TCPDF;

#[Route('/espace')]
class EspaceController extends AbstractController
{
    #[Route('/', name: 'app_espace_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
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

            
        return $this->render('espace/index.html.twig', [
            'espaces' => $espaces,
            'Disponible' => $Disponible,
            'NonDisponible' => $NonDisponible
        ]);


 


    }
    #[Route('/user', name: 'app_espace_user', methods: ['GET'])]
    public function affiche(EntityManagerInterface $entityManager): Response
    {
        $espaces = $entityManager
            ->getRepository(Espace::class)
            ->findAll();

        return $this->render('espace/user.html.twig', [
            'espaces' => $espaces,
        ]);
    }

    #[Route('/new', name: 'app_espace_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, NotifierInterface $notifier): Response
    {
        $espace = new Espace();
        $form = $this->createForm(EspaceType::class, $espace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($espace);
            $entityManager->flush();
        // Envoyer la notification
        $notification = new \Symfony\Component\Notifier\Notification\Notification('l\'espace a été ajouté avec succès. ', ['browser']);
        $notifier->send($notification);
            return $this->redirectToRoute('app_espace_index', [], Response::HTTP_SEE_OTHER);
        }
        

        return $this->renderForm('espace/new.html.twig', [
            'espace' => $espace,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_espace_show', methods: ['GET'])]
    public function show(Espace $espace): Response
    {
        return $this->render('espace/show.html.twig', [
            'espace' => $espace,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_espace_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Espace $espace, EntityManagerInterface $entityManager, NotifierInterface $notifier): Response
    {
        $form = $this->createForm(EspaceType::class, $espace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_espace_index', [], Response::HTTP_SEE_OTHER);
        }
        // Envoyer la notification
$notification = new \Symfony\Component\Notifier\Notification\Notification('l\'espace a été modifier avec succès. ', ['browser']);
$notifier->send($notification);

        return $this->renderForm('espace/edit.html.twig', [
            'espace' => $espace,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_espace_delete', methods: ['POST'])]
    public function delete(Request $request, Espace $espace, EntityManagerInterface $entityManager, NotifierInterface $notifier): Response
    {
        if ($this->isCsrfTokenValid('delete'.$espace->getId(), $request->request->get('_token'))) {
            $entityManager->remove($espace);
            $entityManager->flush();
            
        }
// Envoyer la notification
$notification = new \Symfony\Component\Notifier\Notification\Notification('l\'espace a été supprimes avec succès. ', ['browser']);
$notifier->send($notification);
        return $this->redirectToRoute('app_espace_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/list', name: 'list', methods: ['GET'])]
    public function pdfAction()
    {
        $html = $this->renderView('pdf/index.html.twig', [
            'title' => 'My PDF',
            'content' => 'This is my PDF content',
        ]);
        
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');
        
        $pdfContent = $pdf->Output('mypdf.pdf', 'S');
        
        return new Response(
            $pdfContent,
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="mypdf.pdf"',
            ]
        );
    }
    // --------------------------------------------------
    

   
}
   

