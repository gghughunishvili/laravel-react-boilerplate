<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\MyResponseTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * @SWG\Swagger(
 *     basePath="/api/v1",
 *     produces={"application/json","text/html"},
 *     consumes={"application/x-www-form-urlencoded"},
 *     @SWG\SecurityScheme(
 *         securityDefinition="Bearer",
 *         type="apiKey",
 *         name="Authorization",
 *         in="header",
 *         description="Authorization with bearer",
 *     ),
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="API Boilerplate",
 *         description="Laravel Based REST-API Boilerplate",
 *         @SWG\Contact(
 *             name="Giorgi Ghughunishvili",
 *             email="g.ghughunishvili@gmail.com"
 *         ),
 *     ),
 *     @SWG\Definition(
 *         definition="Error",
 *         required={"error"},
 *         @SWG\Property(
 *             property="error",
 *             type="string",
 *             default="message",
 *         ),
 *     )
 * )
 * @SWG\Tag(
 *   name="Auth",
 *   description="Get access for services with token"
 * ),
 * @SWG\Tag(
 *   name="User",
 *   description="Management of users, with their all endpoints"
 * ),
 * @SWG\Tag(
 *   name="Role",
 *   description="Management of roles, with their all endpoints"
 * ),
 * @SWG\Tag(
 *   name="Permission",
 *   description="Management of permissions, with their all endpoints"
 * ),
 */
abstract class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, MyResponseTrait;
}
