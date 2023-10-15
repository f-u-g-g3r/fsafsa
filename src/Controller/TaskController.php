<?php
namespace App\Controller;

use App\Entity\Task;
use App\Form\Type\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    #[Route('/form')]
    public function new(Request $request): Response {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            return $this->redirectToRoute('task_success');
        }

        return $this->render('task/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/tasks', methods: ['POST'])]
    public function addTask(EntityManagerInterface $entityManager, Request $request): Response {
        $data = $request->getPayload();
        $task = new Task();
        $task->setTask($data->get('task'));
        $task->setDueDate($data->get('dueDate'));

        $entityManager->persist($task);
        $entityManager->flush();

        return new Response('OK', 200);
    }

    #[Route('/tasks', methods: ['GET'])]
    public function all(TaskRepository $repository): JsonResponse {
        $tasks = $repository->findAll();

        $tasks2 = array_map(
            function (Task $task) {
                return ['id' => $task->getId(), 'task' => $task->getTask(), 'dueDate' => $task->getDueDate()];
            },
            $tasks
        );

        return new JsonResponse($tasks2, 200);
    }

    #[Route('/tasks/{id}', methods: ['GET'])]
    public function one(Task $task): JsonResponse {
        $response = ['id' => $task->getId(), 'task' => $task->getTask(), 'dueDate' => $task->getDueDate()];
        return new JsonResponse($response, 200);
    }

    #[Route('/tasks/{id}', methods: ['POST'])]
    public function update(EntityManagerInterface $entityManager, Task $task, Request $request): Response {
        $newTask = $request->getPayload();

        $task->setTask($newTask->get('task'));
        $task->setDueDate($newTask->get('dueDate'));

        $entityManager->persist($task);
        $entityManager->flush();

        return new Response('OK', 200);
    }

    #[Route('/tasks/{id}', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, Task $task): Response {
        $entityManager->remove($task);
        $entityManager->flush();

        return new Response('ok', 200);
    }
}
