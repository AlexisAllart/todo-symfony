<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $user = $em->getRepository(User::class)->findOneById($request->request->get('user_id'));
        $task = new Task;
        $task->setTitle($request->request->get('title'));
        $task->setDescription($request->request->get('description'));
        $task->setStatus($request->request->get('status'));
        $task->setUserId($user);
        $em->persist($task);
        $em->flush();
        return new Response('SUCCESS: New task "'.$task->getTitle().'" created', Response::HTTP_CREATED);
    }

    /**
     * @Route("/task/list/{user_id}", name="task.list", methods="GET")
     * 
     * @param Request $request
     * @param EntityManagerInterface $em
     */
    public function list($user_id, EntityManagerInterface $em) : Response
    {
        $taskList = $em->getRepository(Task::class)->findBy(
            array('user_id'  => $user_id)
        );
        $array=[];
        foreach ($taskList as $task) {
            array_push($array,[
                'id'            => $task->getId(),
                'title'         => $task->getTitle(),
                'description'   => $task->getDescription(),
                'status'        => $task->getStatus(),
                'user_id'       => $task->getUserId()->getId()
            ]);
        }
        $response = new Response(json_encode($array), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("task/details/{id}", name="task.details", methods="GET", requirements={"id" = "\d+"})
     * 
     * @param Request $request
     * @param EntityManagerInterface $em
     */
    public function details($id, EntityManagerInterface $em)
    {
        $task = $em->getRepository(Task::class)->findOneById($id);
        $data = [
            'id'            => $task->getId(),
            'title'         => $task->getTitle(),
            'description'   => $task->getDescription(),
            'status'        => $task->getStatus(),
            'user_id'       => $task->getUserId()->getId()
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
    public function delete($id, EntityManagerInterface $em)
    {
        $task = $em->getRepository(Task::class)->findOneById($id);
        $taskTitle = $task->getTitle();
        $em->remove($task);
        $em->flush();
        $response = new Response('SUCCESS : Task "'.$taskTitle.'" deleted', Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
