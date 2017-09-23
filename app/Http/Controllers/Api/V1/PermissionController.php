<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Permissions\Create;
use App\Http\Requests\Permissions\Delete;
use App\Http\Requests\Permissions\Find;
use App\Http\Requests\Permissions\Get;
use App\Http\Requests\Permissions\Update;
use App\Services\PermissionService;
use App\Transformers\PermissionTransformer;
use Fractal;


class PermissionController extends ApiController
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * @SWG\Post(
     *     path="/permissions",
     *     description="Create a permission",
     *     tags={"Permission"},
     *     @SWG\Parameter(
     *         description="Permission Code name",
     *         name="name",
     *         required=true,
     *         in="formData",
     *         type="string",
     *         default="",
     *     ),
     *     @SWG\Parameter(
     *         description="Permission Display name",
     *         name="display_name",
     *         required=true,
     *         in="formData",
     *         type="string",
     *         default="",
     *     ),
     *     @SWG\Parameter(
     *         description="Permission Description",
     *         name="description",
     *         required=true,
     *         in="formData",
     *         type="string",
     *         default="",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Permission has been created!",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Wrong parameters passed, see details in response",
     *     ),
     * )
     */
    public function create(Create $request)
    {   
        $data=$this->permissionService->create($request->request);
        
        return Fractal::item($data)
            ->transformWith(new PermissionTransformer)
            ->withResourceName('permission');
    }

    /**
     * @SWG\Patch(
     *     path="/permissions/{id}",
     *     description="Update the permission",
     *     tags={"Permission"},
     *     @SWG\Parameter(
     *         description="Permission ID (UUID)",
     *         name="id",
     *         required=true,
     *         in="path",
     *         type="string",
     *         default="",
     *     ),
     *     @SWG\Parameter(
     *         description="Permission Display name",
     *         name="display_name",
     *         required=false,
     *         in="formData",
     *         type="string",
     *         default="",
     *     ),
     *     @SWG\Parameter(
     *         description="Permission Description",
     *         name="description",
     *         required=false,
     *         in="formData",
     *         type="string",
     *         default="",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Permission has been created!",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="The permission not found",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Validation error, details see in message",
     *     ),
     * )
     */
    public function update($id, Update $request)
    {   
        $data=$this->permissionService->update($id, $request->request);
        
        return Fractal::item($data)
            ->transformWith(new PermissionTransformer)
            ->withResourceName('permission');
    }

    /**
     * @SWG\Get(
     *     path="/permissions/{id}",
     *     description="Get the permission by id",
     *     tags={"Permission"},
     *     @SWG\Parameter(
     *         description="Permission ID (UUID)",
     *         name="id",
     *         required=true,
     *         in="path",
     *         type="string",
     *         default="",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Permission has been returned successfully!",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="The permission with given id wasn't found!",
     *     ),
     * )
     */
    public function get($id, Get $request)
    {   
        $data=$this->permissionService->get($id);
        
        return Fractal::item($data)
            ->transformWith(new PermissionTransformer)
            ->withResourceName('permission');
    }

    /**
     * @SWG\Get(
     *     path="/permissions",
     *     description="Get all permissions",
     *     tags={"Permission"},
     *     @SWG\Parameter(
     *         description="Permission ID (UUID)",
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
        $data=$this->permissionService->find($request->request);
        
        return Fractal::collection($data)
            ->transformWith(new PermissionTransformer)
            ->withResourceName('permission');
    }

    /**
     * @SWG\Delete(
     *     path="/permissions/{id}",
     *     description="Delete the permission by id",
     *     tags={"Permission"},
     *     @SWG\Parameter(
     *         description="Permission ID (UUID)",
     *         name="id",
     *         required=true,
     *         in="path",
     *         type="string",
     *         default="",
     *     ),
     *     @SWG\Response(
     *         response=204,
     *         description="Permission has been deleted successfully!",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="The permission with given id wasn't found!",
     *     ),
     * )
     */
    public function delete($id, Delete $request)
    {   
        $data=$this->permissionService->delete($id);
        
        return $this->respondNoContent();
    }
}
