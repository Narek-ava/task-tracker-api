<?php

namespace App\Http\Controllers;


namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Task Tracker API",
 *     description="Документация для API трекинга задач",
 *     @OA\Contact(
 *         email="support@example.com"
 *     )
 * ),
 * @OA\Server(
 *     url="L5_SWAGGER_CONST_HOST",
 *     description="Public server"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
abstract class Controller
{
    //
}
