<?php

namespace App\Http\Controllers;


use Illuminate\Routing\Controller as BaseController; 

/**
 * @OA\Info(
 * version="1.0.0",
 * title="User Product Management API",
 * description="API Documentation for the Technical Test",
 * @OA\Contact(
 * email="your-email@example.com"
 * )
 * )
 *
 * @OA\Server(
 * url=L5_SWAGGER_CONST_HOST,
 * description="API Server"
 * )
 *
 * @OA\SecurityScheme(
 * securityScheme="bearerAuth",
 * type="http",
 * scheme="bearer"
 * )
 */

abstract class Controller extends BaseController
{
    //
}