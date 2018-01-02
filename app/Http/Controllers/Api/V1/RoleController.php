<?php

namespace App\Http\Controllers\Api\V1;

use App\Transformers\RoleTransformer;
use App\Validators\Role\StoreValidator;
use Fractal;

class RoleController extends ApiController
{
    /**
     * @SWG\Post(
     *     path="/roles",
     *     description="Handle a registration request for the application.",
     *     tags={"Role"},
     *     @SWG\Parameter(
     *         description="Role name",
     *         name="name",
     *         required=true,
     *         in="formData",
     *         type="string",
     *         default="moderator"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Role has created successfully!",
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="No permission to create a role",
     *     )
     * )
     */
    public function create(StoreValidator $validator)
    {
        $role = $this->getRoleService()->create($validator);

        return Fractal::item($role)
            ->transformWith(new RoleTransformer)
            ->withResourceName('Role');
    }

    /**
     * @SWG\Get(
     *     path="/roles/{id}",
     *     description="Get specific role",
     *     tags={"Role"},
     *     @SWG\Parameter(
     *         description="ID",
     *         name="id",
     *         required=true,
     *         in="path",
     *         type="integer",
     *         default="1"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Role has been found successfully!",
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="No permission to get role!",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Role not found!",
     *     )
     * )
     */
    public function get(int $id)
    {
        $role = $this->getRoleService()->get($id);

        return Fractal::item($role)
            ->transformWith(new RoleTransformer)
            ->withResourceName('Role');
    }

    /**
     * @SWG\Get(
     *     path="/roles",
     *     description="Find all roles",
     *     tags={"Role"},
     *     @SWG\Response(
     *         response=200,
     *         description="Role has been found successfully!",
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="No permission to find roles!",
     *     )
     * )
     */
    public function find()
    {
        $roles = $this->getRoleService()->find();

        return Fractal::collection($roles)
            ->transformWith(new RoleTransformer)
            ->withResourceName('Role');
    }

    /**
     * @SWG\Delete(
     *     path="/roles/{id}",
     *     description="Delete specific role",
     *     tags={"Role"},
     *     @SWG\Parameter(
     *         description="ID",
     *         name="id",
     *         required=true,
     *         in="path",
     *         type="integer",
     *         default="2"
     *     ),
     *     @SWG\Response(
     *         response=204,
     *         description="Role has been deleted successfully, No Content!",
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="No permission to delete role!",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Role not found!",
     *     ),
     * )
     */
    public function delete(int $id)
    {
        $role = $this->getRoleService()->delete($id);

        return $this->respondNoContent();
    }

    /**
     * @SWG\Get(
     *     path="/roles/{id}/permissions",
     *     description="Get all permissions for the role",
     *     tags={"Role"},
     *     @SWG\Parameter(
     *         description="Role ID",
     *         name="id",
     *         required=true,
     *         in="path",
     *         type="integer",
     *         default="1"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Role dat has been returned successfully!",
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="No permission to get role permissions!",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Role not found!",
     *     )
     * )
     */
    public function getPermissions(int $id)
    {
        $role = $this->getRoleService()->getPermissions($id);

        return Fractal::item($role)
            ->transformWith(new RoleTransformer)
            ->withResourceName('Role')
            ->parseIncludes('permissions');
    }

    /**
     * @SWG\Post(
     *     path="/roles/{roleId}/permissions/{permissionId}",
     *     description="Attach permission to the role",
     *     tags={"Role"},
     *     @SWG\Parameter(
     *         description="Role ID",
     *         name="roleId",
     *         required=true,
     *         in="path",
     *         type="integer",
     *         default="2"
     *     ),
     *     @SWG\Parameter(
     *         description="Permission ID",
     *         name="permissionId",
     *         required=true,
     *         in="path",
     *         type="integer",
     *         default="1"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Permission has been added to role successfully!",
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="No permission to attach permission to role!",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Role or Permission not found!",
     *     ),
     * )
     */
    public function attachPermission(int $roleId, int $permissionId)
    {
        $role = $this->getRoleService()->attachPermission($roleId, $permissionId);

        return Fractal::item($role)
            ->transformWith(new RoleTransformer)
            ->withResourceName('Role')
            ->parseIncludes('permissions');
    }

    /**
     * @SWG\Delete(
     *     path="/roles/{roleId}/permissions/{permissionId}",
     *     description="Detach a permission to the role",
     *     tags={"Role"},
     *     @SWG\Parameter(
     *         description="Role ID",
     *         name="roleId",
     *         required=true,
     *         in="path",
     *         type="integer",
     *         default="2"
     *     ),
     *     @SWG\Parameter(
     *         description="Permission ID",
     *         name="permissionId",
     *         required=true,
     *         in="path",
     *         type="integer",
     *         default="1"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Permission has been removed from the role successfully!",
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="No permission to detach permission from role!",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Role or Permission not found!",
     *     ),
     * )
     */
    public function detachPermission(int $roleId, int $permissionId)
    {
        $role = $this->getRoleService()->detachPermission($roleId, $permissionId);

        return Fractal::item($role)
            ->transformWith(new RoleTransformer)
            ->withResourceName('Role')
            ->parseIncludes('permissions');
    }
}
