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
    public function create($userid, Request $request, EntityManagerInterface $em)
    {
        $task = new User;
        $task->setTitle($request->request->get('title'));
        $task->setDescription($request->request->get('description'));
        $task->setStatus($request->request->get('status'));
        $task->setUserId($userid);
        $em->persist($task);
        $em->flush();
        return new Response('SUCCESS: New task "'.$task->getTitle().'" created', Response::HTTP_CREATED);
    }

    /**
     * @Route("/task/list", name="task.list", methods="GET")
     * 
     * @param Request $request
     * @param EntityManagerInterface $em
     */
    public function list($userid, EntityManagerInterface $em) : Response
    {
        $taskList = $em->getRepository(Task::class)->findBy(
            array('user_id'  => $userid)
        );
        $data=[];
        foreach ($taskList as $task) {
            array_push(json_encode($data,[
                'id'            => $task->getId(),
                'title'         => $task->getTitle(),
                'description'   => $task->getDescription(),
                'status'        => $task->getStatus(),
                'user_id'       => $task->getUserId()
            ]));
        }
        $response = new Response($data, Response::HTTP_OK);
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
        $data = [
            'id'            => $task->getId(),
            'title'         => $task->getTitle(),
            'description'   => $task->getDescription(),
            'status'        => $task->getStatus(),
            'user_id'       => $task->getUserId()
        ];
        $response = new Response(json_encode($data), Response::HTTP_OK);
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
        $response = new Response('SUCCESS : "'.$task->getTitle.'" deleted', Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
    }
}
