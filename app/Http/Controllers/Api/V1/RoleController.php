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
            ->withResourceName('role');
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
            ->withResourceName('role');
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
            ->withResourceName('role');
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
}
