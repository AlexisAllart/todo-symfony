<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    /**
     * @Route("/user/create", name="user.create", methods="POST")
     * 
     * @param Request $request
     * @param EntityManagerInterface $em
     */
    public function create(Request $request, EntityManagerInterface $em)
    {
        $data = $request->getContent();
        $user = $this->get('jms_serializer')->deserialize($data, User::class, 'json');
        $em->persist($user);
        $em->flush();
        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @Route("/user/edit/{id}", name="user.edit", methods="PUT", requirements={"id" = "\d+"})
     * 
     * @param Request $request
     * @param EntityManagerInterface $em
     */
    public function edit($id, Request $request, EntityManagerInterface $em)
    {
        $input = $request->getContent();
        $data = $this->get('jms_serializer')->serialize($input, 'json');
        $user = $em->getRepository(User::class)->findOneById($id);
        $user->setEmail($data->getEmail);
        $user->setFirstName($data->getFirstName);
        $user->setLastName($data->getLastName);
        $user->setPassword($data->getPassword);
        $user->setRole($data->getRole);
        $user->setUpdatedAt(new \DateTime);
        $em->flush();
        return new Response('', Response::HTTP_ACCEPTED);
    }
}