<?php

namespace App\Http\Controllers\Api\V1;

use App\Transformers\PermissionTransformer;
use Fractal;

class PermissionController extends ApiController
{
    /**
     * @SWG\Get(
     *     path="/permissions",
     *     description="Find all permissions",
     *     tags={"Permission"},
     *     @SWG\Response(
     *         response=200,
     *         description="Permissions has been found successfully!",
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="No permission to find permissions!",
     *     )
     * )
     */
    public function find()
    {
        $permissions = $this->getPermissionService()->find();

        return Fractal::collection($permissions)
            ->transformWith(new PermissionTransformer)
            ->withResourceName('Permission');
    }
}
