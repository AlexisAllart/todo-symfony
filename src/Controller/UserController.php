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
        $user = new User;
        $user->setFirstName($request->request->get('firstName'));
        $user->setLastName($request->request->get('lastName'));
        $user->setEmail($request->request->get('email'));
        $user->setPassword(hash('sha256',$request->request->get('password')));
        $user->setRole('User');
        $user->setCreatedAt(new \DateTime);
        $user->setUpdatedAt(new \DateTime);
        $em->persist($user);
        $em->flush();
        return new Response('SUCCESS: New user '.$user->getFirstName().' '.$user->getLastName().' created', Response::HTTP_CREATED);
    }

    /**
     * @Route("/user/edit/{id}", name="user.edit", methods="PUT", requirements={"id" = "\d+"})
     * 
     * @param Request $request
     * @param EntityManagerInterface $em
     */
    public function edit($id, Request $request, EntityManagerInterface $em)
    {
        $user = $em->getRepository(User::class)->findOneById($id);
        $user->setFirstName($request->request->get('firstName'));
        $user->setLastName($request->request->get('lastName'));
        $user->setEmail($request->request->get('email'));
        $user->setPassword(hash('sha256',$request->request->get('password')));
        // $user->setUpdatedAt(new \DateTime);
        $em->flush();
        return new Response('SUCCESS: User "'.$user->getFirstName().' '.$user->getLastName().'" edited', Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/user/login/{id}"), name="user.login", methods="POST", requirements={"id" = "\d+"})
     * 
     * @param Request $request
     * @param EntityManagerInterface $em
     */
    public function login($id, Request $request, EntityManagerInterface $em)
    {
        $user = $em->getRepository(User::class)->findOneById($id);
        if (
            $user->getPassword() == hash('sha256',$request->request->get('password'))
            &&
            $user->getEmail() == $request->request->get('email')
            ) {
            $response = new Response(json_encode($user));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }
}