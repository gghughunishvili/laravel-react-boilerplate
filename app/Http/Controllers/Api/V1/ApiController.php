<?php

namespace App\Http\Controllers\Api\V1;

use App;
use App\Services\PermissionService;
use App\Services\RoleService;
use App\Services\UserService;
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
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="API Boilerplate",
 *         description="Laravel Based REST-API Boilerplate",
 *         @SWG\Contact(
 *             name="Giorgi Ghughunishvili",
 *             email="g.ghughunishvili@gmail.com"
 *         ),
 *     ),
 *     security={
 *          {"api_key": {}}
 *     }
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
 *   description="Management of permissions' endpoints"
 * ),
 */
abstract class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, MyResponseTrait;

    public function getRoleService() {
        return App::make(RoleService::class);
    }

    public function getPermissionService() {
        return App::make(PermissionService::class);
    }

    public function getUserService() {
        return App::make(UserService::class);
    }
}
