<?php



/**
 * @OA\Schema(
 *     schema="Task",
 *     type="object",
 *     required={"id","title","status","priority","user_id"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Новая задача"),
 *     @OA\Property(property="description", type="string", example="Описание задачи"),
 *     @OA\Property(property="status", type="string", enum={"new","in_progress","completed","cancelled"}, example="new"),
 *     @OA\Property(property="priority", type="string", enum={"high","normal","low"}, example="high"),
 *     @OA\Property(property="user_id", type="integer", example=2),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-17T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-17T12:00:00Z")
 * )
 */

/**
 * @OA\Schema(
 *     schema="TaskComment",
 *     type="object",
 *     required={"id","task_id","user_id","comment"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="task_id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=2),
 *     @OA\Property(property="comment", type="string", example="Комментарий к задаче"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-17T12:05:00Z")
 * )
 */

/**
 * @OA\Schema(
 *     schema="TaskWithComments",
 *     type="object",
 *     @OA\Property(property="task", ref="#/components/schemas/Task"),
 *     @OA\Property(property="comments", type="array", @OA\Items(ref="#/components/schemas/TaskComment"))
 * )
 */

