<?php

namespace App\Controller;

use App\Entity\Typespace;
use App\Entity\User;
use App\Repository\TypespaceRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MOBILEController extends AbstractController
{

    #[Route("/allUsers", name: "Users")]
    //* Dans cette fonction, nous utilisons les services NormlizeInterface et StudentRepository, 
    //* avec la méthode d'injection de dépendances.
    public function user(UserRepository $repo, SerializerInterface $serializer)
    {
        $users = $repo->findAll();


        $json = $serializer->serialize($users, 'json', ['groups' => "typespace"]);

        //* Nous renvoyons une réponse Http qui prend en paramètre un tableau en format JSON
        return new Response($json);
    }

    #[Route("/User/{id}", name: "User")]
    public function UserId($id, NormalizerInterface $normalizer, UserRepository $repo)
    {
        $User = $repo->find($id);
        $userNormalises = $normalizer->normalize($User, 'json', ['groups' => "typespace"]);
        return new Response(json_encode($userNormalises));
    }


    #[Route("/addUserJSON/new", name: "addUserJSON")]
    public function adduserJSON(Request $req, EntityManager $em, UserRepository $user,  NormalizerInterface $Normalizer)
    {
        $User = new User();
        $user->setLastName($req->get('nom'));
        $user->setFirstName($req->get('prenom'));
        $user->setBirthday($req->get('birthday'));
        $user->set($req->get('CIN'));
        $user->setNumTel($req->get('Num'));
        $user->setRole($req->get('role'));
        $user->setEmail($req->get('Email'));
        $user->setPassword($req->get('nom'));

        $em->persist($user);
        $em->flush();

        $jsonContent = $Normalizer->normalize($User, 'json', ['groups' => 'user']);
        return new Response(json_encode($jsonContent));
    }

    #[Route("/updateUserJSON/{id}", name: "updateUserJSON")]
    public function updateUserJSON(Request $req, EntityManager $em,  NormalizerInterface $Normalizer, int $id)
    {

        $user = $em->getRepository(Typespace::class)->find($id);

        $user->setTypeespace($req->get('user'));


        $em->flush();

        $jsonContent = $Normalizer->normalize($user, 'json', ['groups' => 'user']);
        return new Response("typespace updated successfully " . json_encode($jsonContent));
    }

    #[Route("deleteUserJSON/{id}", name: "deleteUserJSON")]
    public function deletetypespaceJSON(Request $req, $id, EntityManager $em, NormalizerInterface $Normalizer)
    {

        $user = $em->getRepository(Typespace::class)->find($id);
        $em->remove($user);
        $em->flush();
        $jsonContent = $Normalizer->normalize($user, 'json', ['groups' => 'user']);
        return new Response("Utilisateur deleted successfully " . json_encode($jsonContent));
    }
}
