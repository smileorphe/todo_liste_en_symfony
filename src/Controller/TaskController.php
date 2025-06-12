<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\TaskPriority;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/task')]
#[IsGranted('ROLE_USER')]
class TaskController extends AbstractController
{
    #[Route('/', name: 'app_task_index', methods: ['GET'])]
    public function index(Request $request, TaskRepository $taskRepository): Response
    {
        $user = $this->getUser();
        
        // Paramètres de filtrage et de tri
        $isCompleted = $request->query->get('completed');
        $priority = $request->query->get('priority');
        $sortBy = $request->query->get('sort', 'createdAt');
        $sortDirection = $request->query->get('direction', 'DESC');
        $page = max(1, $request->query->getInt('page', 1));
        $limit = 9; // Nombre de tâches par page
        
        // Convertir le paramètre isCompleted en booléen si nécessaire
        if ($isCompleted !== null) {
            $isCompleted = $isCompleted === '1' || $isCompleted === 'true';
        }
        
        // Calculer l'offset pour la pagination
        $offset = ($page - 1) * $limit;
        
        // Récupérer les tâches avec filtres et pagination
        $tasks = $taskRepository->findByUserWithFilters(
            $user,
            $isCompleted,
            $priority,
            $sortBy,
            $sortDirection,
            $limit,
            $offset
        );
        
        // Compter le nombre total de tâches pour la pagination
        $totalTasks = count($taskRepository->findByUserWithFilters(
            $user,
            $isCompleted,
            $priority
        ));
        
        $totalPages = ceil($totalTasks / $limit);
        
        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
            'filters' => [
                'completed' => $isCompleted,
                'priority' => $priority,
                'sort' => $sortBy,
                'direction' => $sortDirection
            ],
            'priorities' => [
                TaskPriority::LOW->value,
                TaskPriority::MEDIUM->value,
                TaskPriority::HIGH->value
            ],
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total_pages' => $totalPages,
                'total_items' => $totalTasks
            ]
        ]);
    }

    #[Route('/new', name: 'app_task_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TaskRepository $taskRepository): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setUser($this->getUser());
            $taskRepository->save($task, true);

            $this->addFlash('success', 'La tâche a été créée avec succès.');
            return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('task/new.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/task/{id}', name: 'app_task_show', methods: ['GET'])]
    public function show(Task $task): Response
    {
        // Vérifier que l'utilisateur a le droit de voir cette tâche
        $this->denyAccessUnlessGranted('view', $task);
        
        return $this->render('task/show.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route('/task/{id}/edit', name: 'app_task_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        // Vérifier que l'utilisateur a le droit de modifier cette tâche
        $this->denyAccessUnlessGranted('edit', $task);
        
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'La tâche a été modifiée avec succès.');
            return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('task/edit.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/task/{id}', name: 'app_task_delete', methods: ['POST'])]
    public function delete(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        // Vérifier que l'utilisateur a le droit de supprimer cette tâche
        $this->denyAccessUnlessGranted('delete', $task);
        
        if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->request->get('_token'))) {
            $entityManager->remove($task);
            $entityManager->flush();
            $this->addFlash('success', 'La tâche a été supprimée avec succès.');
        }

        return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/task/{id}/toggle', name: 'app_task_toggle', methods: ['POST'])]
    public function toggleCompleted(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        // Vérifier que l'utilisateur a le droit de modifier cette tâche
        $this->denyAccessUnlessGranted('edit', $task);
        
        if ($this->isCsrfTokenValid('toggle'.$task->getId(), $request->request->get('_token'))) {
            // Inverser le statut de complétion
            $task->setIsCompleted(!$task->isIsCompleted());
            $entityManager->flush();
            
            $status = $task->isIsCompleted() ? 'terminée' : 'à faire';
            $this->addFlash('success', "La tâche a été marquée comme {$status}.");
        }
        
        return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
    }
}
