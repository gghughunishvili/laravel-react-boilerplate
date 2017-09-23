<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Roles\AddPermission;
use App\Http\Requests\Roles\Create;
use App\Http\Requests\Roles\Delete;
use App\Http\Requests\Roles\Find;
use App\Http\Requests\Roles\Get;
use App\Http\Requests\Roles\RemovePermission;
use App\Http\Requests\Roles\Update;
use App\Services\RoleService;
use App\Transformers\RoleTransformer;
use Fractal;

class RoleController extends ApiController
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * @SWG\Post(
     *     path="/roles",
     *     description="Create a role",
     *     tags={"Role"},
     *     @SWG\Parameter(
     *         description="Role Code name",
     *         name="name",
     *         required=true,
     *         in="formData",
     *         type="string",
     *         default="",
     *     ),
     *     @SWG\Parameter(
     *         description="Role Display name",
     *         name="display_name",
     *         required=true,
     *         in="formData",
     *         type="string",
     *         default="",
     *     ),
     *     @SWG\Parameter(
     *         description="Role Description",
     *         name="description",
     *         required=true,
     *         in="formData",
     *         type="string",
     *         default="",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Role has been created!",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Wrong parameters passed, see details in response",
     *     ),
     * )
     */
    public function create(Create $request)
    {
        $data = $this->roleService->create($request->request);

        return Fractal::item($data)
            ->transformWith(new RoleTransformer)
            ->withResourceName('role');
    }

    /**
     * @SWG\Patch(
     *     path="/roles/{id}",
     *     description="Update the role",
     *     tags={"Role"},
     *     @SWG\Parameter(
     *         description="Role ID (UUID)",
     *         name="id",
     *         required=true,
     *         in="path",
     *         type="string",
     *         default="",
     *     ),
     *     @SWG\Parameter(
     *         description="Role Display name",
     *         name="display_name",
     *         required=false,
     *         in="formData",
     *         type="string",
     *         default="",
     *     ),
     *     @SWG\Parameter(
     *         description="Role Description",
     *         name="description",
     *         required=false,
     *         in="formData",
     *         type="string",
     *         default="",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Role has been created!",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="The role not found",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Validation error, details see in message",
     *     ),
     * )
     */
    public function update($id, Update $request)
    {
        $data = $this->roleService->update($id, $request->request);

        return Fractal::item($data)
            ->transformWith(new RoleTransformer)
            ->withResourceName('role');
    }

    /**
     * @SWG\Get(
     *     path="/roles/{id}",
     *     description="Get the role by id",
     *     tags={"Role"},
     *     @SWG\Parameter(
     *         description="Role ID (UUID)",
     *         name="id",
     *         required=true,
     *         in="path",
     *         type="string",
     *         default="",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Role has been returned successfully!",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="The role with given id wasn't found!",
     *     ),
     * )
     */
    public function get($id, Get $request)
    {
        $data = $this->roleService->get($id);

        return Fractal::item($data)
            ->transformWith(new RoleTransformer)
            ->withResourceName('role')
            ->parseIncludes('permissions');
    }

    /**
     * @SWG\Get(
     *     path="/roles",
     *     description="Get all roles",
     *     tags={"Role"},
     *     @SWG\Parameter(
     *         description="Role ID (UUID)",
     *         name="id",
     *         required=false,
     *         in="query",
     *         type="string",
     *         default="",
     *     ),
     *     @SWG\Parameter(
     *         description="Name",
     *         name="name",
     *         required=false,
     *         in="query",
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         description="Display Name",
     *         name="display_name",
     *         required=false,
     *         in="query",
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         description="Description",
     *         name="description",
     *         required=false,
     *         in="query",
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         default="10",
     *     ),
     *     @SWG\Parameter(
     *         name="offset",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         default="0",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Roles have been returned successfully!",
     *     )
     * )
     */
    public function find(Find $request)
    {
        $data = $this->roleService->find($request->request);

        return Fractal::collection($data)
            ->transformWith(new RoleTransformer)
            ->withResourceName('role');
    }

    /**
     * @SWG\Delete(
     *     path="/roles/{id}",
     *     description="Delete the role by id",
     *     tags={"Role"},
     *     @SWG\Parameter(
     *         description="Role ID (UUID)",
     *         name="id",
     *         required=true,
     *         in="path",
     *         type="string",
     *         default="",
     *     ),
     *     @SWG\Response(
     *         response=204,
     *         description="Role has been deleted successfully!",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="The role with given id wasn't found!",
     *     ),
     * )
     */
    public function delete($id, Delete $request)
    {
        $data = $this->roleService->delete($id);

        return $this->respondNoContent();
    }

    /**
     * @SWG\Post(
     *     path="/roles/{role_id}/permissions/{permission_id}",
     *     description="Attach permission to the role",
     *     tags={"Role"},
     *     @SWG\Parameter(
     *         description="Role ID",
     *         name="role_id",
     *         required=true,
     *         in="path",
     *         type="string",
     *         default="",
     *     ),
     *     @SWG\Parameter(
     *         description="Permission ID",
     *         name="permission_id",
     *         required=true,
     *         in="path",
     *         type="string",
     *         default="",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Permission has been attached succesfully!",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="The permission is already attached to the role",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="A permission or a role with given id wasn't found!",
     *     ),
     * )
     */
    public function addPermission($role_id, $permission_id, AddPermission $request)
    {
        $data = $this->roleService->attachPermission($role_id, $permission_id);

        return Fractal::item($data)
            ->transformWith(new RoleTransformer)
            ->withResourceName('role')
            ->parseIncludes('permissions');
    }

    /**
     * @SWG\Delete(
     *     path="/roles/{role_id}/permissions/{permission_id}",
     *     description="Remove permission from the role",
     *     tags={"Role"},
     *     @SWG\Parameter(
     *         description="Role ID",
     *         name="role_id",
     *         required=true,
     *         in="path",
     *         type="string",
     *         default="",
     *     ),
     *     @SWG\Parameter(
     *         description="Permission ID",
     *         name="permission_id",
     *         required=true,
     *         in="path",
     *         type="string",
     *         default="",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Permission has been removed succesfully!",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="The permission isn't attached to the role",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="A permission or a role with given id wasn't found!",
     *     ),
     * )
     */
    public function removePermission($role_id, $permission_id, RemovePermission $request)
    {
        $data = $this->roleService->detachPermission($role_id, $permission_id);

        return Fractal::item($data)
            ->transformWith(new RoleTransformer)
            ->withResourceName('role')
            ->parseIncludes('permissions');
    }
}
