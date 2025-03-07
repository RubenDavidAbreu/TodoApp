<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/task')]
final class TaskController extends AbstractController
{
    #[Route('/', name: 'app_task_index', methods: ['GET'])]
public function index(TaskRepository $taskRepository, Request $request): Response
{
    $statusFilter = $request->query->get('status');


    if ($statusFilter === '1') {
        $tasks = $taskRepository->findBy(['status' => true]);
    } 

    elseif ($statusFilter === '0') {
        $tasks = $taskRepository->findBy(['status' => false]);
    } 

    else {
        $tasks = $taskRepository->findAll();
    }

    return $this->render('task/index.html.twig', [
        'tasks' => $tasks,
    ]);
}



    #[Route('/new', name: 'app_task_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('task/new.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_task_show', methods: ['GET'])]
    public function show(Task $task): Response
    {
        return $this->render('task/show.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_task_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('task/edit.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_task_delete', methods: ['POST'])]
    public function delete(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
      
        if ($this->isCsrfTokenValid('delete' . $task->getId(), $request->get('_token'))) {
            $entityManager->remove($task);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
    }
    
    
    #[Route('/{id}/mark-done', name: 'app_task_mark_done', methods: ['POST'])]
    public function markDone(Task $task, EntityManagerInterface $entityManager): Response
    {
        $task->setStatus(true); 
        $entityManager->flush();
    
        return $this->redirectToRoute('app_task_index');
    }
    
    #[Route('/api/tasks', name: 'api_task_index', methods: ['GET'])]
    public function apiIndex(TaskRepository $taskRepository): JsonResponse
    {
       
        $tasks = $taskRepository->findAll();

       
        $data = [];
        foreach ($tasks as $task) {
            $data[] = [
                'id' => $task->getId(),
                'title' => $task->getTitle(),
                'description' => $task->getDescription(),
                'status' => $task->getStatus(),
                'created_at' => $task->getCreatedAt()->format('Y-m-d H:i:s'), // Format de la date
            ];
        }

      
        return new JsonResponse($data);
    }

    
}
