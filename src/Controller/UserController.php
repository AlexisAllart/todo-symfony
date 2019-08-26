<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Route("/user/create", name="user.create", methods="POST")
     * 
     * @param Request $request
     * @param EntityManagerInterface $em
     */
    public function create($params, Request $request, EntityManagerInterface $em)
    {
// Deserialize $params etc...
    }

    /**
     * @Route("/user/edit/{id}", name="user.edit", methods="POST")
     * 
     * @param Request $request
     * @param EntityManagerInterface $em
     */
    public function edit($id, Request $request, EntityManagerInterface $em)
    {
// Deserialize $params etc...
    }
}