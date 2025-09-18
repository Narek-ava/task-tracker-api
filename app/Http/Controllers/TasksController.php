<?php


namespace App\Http\Controllers;

use App\DTO\Task\TaskCommentDTO;
use App\DTO\Task\TaskCreateDTO;
use App\DTO\Task\TaskUpdateStatusDTO;
use App\Http\Requests\TaskCommentRequest;
use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\TaskIndexRequest;
use App\Http\Requests\TaskUpdateStatusRequest;
use App\Http\Resources\TaskCommentResource;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskWithCommentsResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Tag(
 *     name="Tasks",
 *     description="API для управления задачами"
 * )
 */
class TasksController extends Controller
{
    public function __construct(protected TaskService $service)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/tasks",
     *     summary="Список задач",
     *     tags={"Tasks"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="status", in="query", description="Фильтр по статусу", @OA\Schema(type="string", enum={"new","in_progress","completed","cancelled"})),
     *     @OA\Parameter(name="priority", in="query", description="Фильтр по приоритету", @OA\Schema(type="string", enum={"high","normal","low"})),
     *     @OA\Parameter(name="user_id", in="query", description="Фильтр по пользователю", @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Список задач",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Новая задача"),
     *                 @OA\Property(property="description", type="string", example="Описание задачи"),
     *                 @OA\Property(property="status", type="string", enum={"new","in_progress","completed","cancelled"}, example="new"),
     *                 @OA\Property(property="priority", type="string", enum={"high","normal","low"}, example="high"),
     *                 @OA\Property(property="user_id", type="integer", example=2),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-17T12:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-17T12:00:00Z")
     *             )
     *         )
     *     )
     * )
     */
    public function index(TaskIndexRequest $request): AnonymousResourceCollection
    {
        $tasks = $this->service->listTasks($request->all());
        return TaskResource::collection($tasks);
    }

    /**
     * @OA\Post(
     *     path="/api/tasks",
     *     summary="Создать новую задачу",
     *     tags={"Tasks"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title"},
     *             @OA\Property(property="title", type="string", example="Новая задача"),
     *             @OA\Property(property="description", type="string", example="Описание задачи"),
     *             @OA\Property(property="user_id", type="integer", example=2),
     *             @OA\Property(property="priority", type="string", enum={"high","normal","low"}, example="high")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Задача создана",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Новая задача"),
     *             @OA\Property(property="description", type="string", example="Описание задачи"),
     *             @OA\Property(property="status", type="string", enum={"new","in_progress","completed","cancelled"}, example="new"),
     *             @OA\Property(property="priority", type="string", enum={"high","normal","low"}, example="high"),
     *             @OA\Property(property="user_id", type="integer", example=2),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-17T12:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-17T12:00:00Z")
     *         )
     *     )
     * )
     */
    public function store(TaskCreateRequest $request): TaskResource
    {
        $dto = new TaskCreateDTO($request->all());
        $task = $this->service->createTask($dto);
        return new TaskResource($task);
    }

    /**
     * @OA\Put(
     *     path="/api/tasks/{id}/status",
     *     summary="Обновить статус задачи",
     *     tags={"Tasks"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status"},
     *             @OA\Property(property="status", type="string", enum={"new","in_progress","completed","cancelled"}, example="completed"),
     *             @OA\Property(property="user_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Статус обновлен",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Новая задача"),
     *             @OA\Property(property="description", type="string", example="Описание задачи"),
     *             @OA\Property(property="status", type="string", enum={"new","in_progress","completed","cancelled"}, example="completed"),
     *             @OA\Property(property="priority", type="string", enum={"high","normal","low"}, example="high"),
     *             @OA\Property(property="user_id", type="integer", example=2),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-17T12:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-17T12:00:00Z")
     *         )
     *     )
     * )
     */
    public function updateStatus(TaskUpdateStatusRequest $request, Task $task): TaskResource
    {
        $dto = new TaskUpdateStatusDTO($request->all());
        $task = $this->service->updateStatus($task, $dto);
        return new TaskResource($task);
    }

    /**
     * @OA\Post(
     *     path="/api/tasks/{id}/comments",
     *     summary="Добавить комментарий к задаче",
     *     tags={"Tasks"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"comment","user_id"},
     *             @OA\Property(property="comment", type="string", example="Комментарий к задаче"),
     *             @OA\Property(property="user_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Комментарий добавлен",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="task_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=2),
     *             @OA\Property(property="comment", type="string", example="Комментарий к задаче"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-17T12:00:00Z")
     *         )
     *     )
     * )
     */
    public function addComment(TaskCommentRequest $request, Task $task): TaskCommentResource
    {
        $dto = new TaskCommentDTO($request->all());
        $comment = $this->service->addComment($task, $dto);
        return new TaskCommentResource($comment);
    }

    /**
     * @OA\Get(
     *     path="/api/tasks/{id}",
     *     summary="Получить задачу с комментариями",
     *     tags={"Tasks"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Задача с комментариями",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Новая задача"),
     *             @OA\Property(property="description", type="string", example="Описание задачи"),
     *             @OA\Property(property="status", type="string", enum={"new","in_progress","completed","cancelled"}, example="new"),
     *             @OA\Property(property="priority", type="string", enum={"high","normal","low"}, example="high"),
     *             @OA\Property(property="user_id", type="integer", example=2),
     *             @OA\Property(
     *                 property="comments",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="task_id", type="integer", example=1),
     *                     @OA\Property(property="user_id", type="integer", example=2),
     *                     @OA\Property(property="comment", type="string", example="Комментарий к задаче"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-17T12:00:00Z")
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=2),
     *                 @OA\Property(property="name", type="string", example="Иван Иванов"),
     *                 @OA\Property(property="position", type="string", enum={"manager","developer","tester"}, example="developer")
     *             ),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-17T12:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-17T12:00:00Z")
     *         )
     *     )
     * )
     */
    public function show(Task $task): TaskWithCommentsResource
    {
        $task = $this->service->getTaskWithComments($task);
        return new TaskWithCommentsResource($task);
    }
}
