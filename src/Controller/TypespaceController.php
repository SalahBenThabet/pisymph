<?php

namespace App\Controller;

use App\Entity\Typespace;
use App\Form\TypespaceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/typespace')]
class TypespaceController extends AbstractController
{
    #[Route('/', name: 'app_typespace_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $typespaces = $entityManager
            ->getRepository(Typespace::class)
            ->findAll();

        return $this->render('typespace/index.html.twig', [
            'typespaces' => $typespaces,
        ]);
    }

    #[Route('/new', name: 'app_typespace_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, NotifierInterface $notifier): Response
    {
        $typespace = new Typespace();
        $form = $this->createForm(TypespaceType::class, $typespace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typespace);
            $entityManager->flush();
            // Envoyer la notification
            $notification = new \Symfony\Component\Notifier\Notification\Notification('le Type espace a été ajouté avec succès. ', ['browser']);
            $notifier->send($notification);

            return $this->redirectToRoute('app_typespace_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('typespace/new.html.twig', [
            'typespace' => $typespace,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_typespace_show', methods: ['GET'])]
    public function show(Typespace $typespace): Response
    {
        return $this->render('typespace/show.html.twig', [
            'typespace' => $typespace,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_typespace_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Typespace $typespace, EntityManagerInterface $entityManager, NotifierInterface $notifier): Response
    {
        $form = $this->createForm(TypespaceType::class, $typespace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            // Envoyer la notification
            $notification = new \Symfony\Component\Notifier\Notification\Notification('le Type espace a été modifier avec succès. ', ['browser']);
            $notifier->send($notification);

            return $this->redirectToRoute('app_typespace_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('typespace/edit.html.twig', [
            'typespace' => $typespace,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_typespace_delete', methods: ['POST'])]
    public function delete(Request $request, Typespace $typespace, EntityManagerInterface $entityManager, NotifierInterface $notifier): Response
    {
        if ($this->isCsrfTokenValid('delete' . $typespace->getId(), $request->request->get('_token'))) {
            $entityManager->remove($typespace);
            $entityManager->flush();
        }
        // Envoyer la notification
        $notification = new \Symfony\Component\Notifier\Notification\Notification('le Type espace a été supprimer avec succès. ', ['browser']);
        $notifier->send($notification);
        return $this->redirectToRoute('app_typespace_index', [], Response::HTTP_SEE_OTHER);
    }
}
