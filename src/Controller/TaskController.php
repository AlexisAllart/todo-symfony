<?php

namespace App\Controller;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends AbstractController
{
    /**
     * @Route("/task/create", name="task.create", methods="POST")
     * 
     * @param Request $request
     * @param EntityManagerInterface $em
     */
    public function create(Request $request, EntityManagerInterface $em)
    {
        $data = $request->getContent();
        $task = $this->get('jms_serializer')->deserialize($data, Task::class, 'json');
        $em->persist($task);
        $em->flush();
        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @Route("/task/list/{id}", name="task.list", methods="GET", requirements={"id" = "\d+"})
     * 
     * @param Request $request
     * @param EntityManagerInterface $em
     */
    public function list($user_id, EntityManagerInterface $em) : Response
    {
        $taskList = $em->getRepository(Task::class)->findBy(
            array('user_id'  => $user_id)
        );
        $data = $this->get('jms_serializer')->serialize($taskList, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("task/details/{id}", name="task.details", methods="GET", requirements={"id" = "\d+"})
     * 
     * @param Request $request
     * @param EntityManagerInterface $em
     */
    public function details($id, Request $request, EntityManagerInterface $em)
    {
        $task = $em->getRepository(Task::class)->findOneById($id);
        $data = $this->get('jms_serializer')->serialize($task, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("task/delete/{id}", name="task.delete", methods="DELETE", requirements={"id" = "\d+"})
     * 
     * @param Request $request
     * @param EntityManagerInterface $em
     */
    public function delete($id, Request $request, EntityManagerInterface $em)
    {
        $task = $em->getRepository(Task::class)->findOneById($id);
        $em->remove($task);
        $em->flush();
        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Route("task/search/{title}", name="task.search", methods="GET")
     * 
     * @param Request $request
     * @param EntityManagerInterface $em
     */
    public function search($title, Request $request, EntityManagerInterface $em)
    {
        $task = $em->getRepository(Task::class)->findOneBy(array(
            'title' => $title
        ));
        $data = $this->get('serializer')->serialize($task, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
