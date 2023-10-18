<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController  extends AbstractController
{
    #[Route("/users", methods: ["POST"])]
    public function addUser(EntityManagerInterface $entityManager, Request $request): Response
    {
        $data = $request->getPayload();
        $user = new User();
        $user->setEmail($data->get('email'));
        $user->setPassword($data->get('password'));

        $entityManager->persist($user);
        $entityManager->flush();

        return new Response("OK");
    }

    #[Route("/users", methods: ["GET"])]
    public function test(): Response {
        return new Response("123");
    }
}