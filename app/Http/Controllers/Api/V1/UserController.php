<?php

namespace App\Http\Controllers\Api\V1;

use App\Transformers\UserTransformer;
use App\Validators\User\CreateValidator;
use App\Validators\User\UpdateValidator;
use Fractal;

class UserController extends ApiController
{
    /**
     * @SWG\Post(
     *     path="/users",
     *     description="Handle a registration request for the application.",
     *     tags={"User"},
     *     @SWG\Parameter(
     *         description="Email",
     *         name="email",
     *         required=true,
     *         in="formData",
     *         type="string",
     *         default="newuser@example.com"
     *     ),
     *     @SWG\Parameter(
     *         description="Fullname",
     *         name="name",
     *         required=true,
     *         in="formData",
     *         type="string",
     *         default="John Doe"
     *     ),
     *     @SWG\Parameter(
     *         description="Username",
     *         name="username",
     *         required=true,
     *         in="formData",
     *         type="string",
     *         default="SomeUsername"
     *     ),
     *     @SWG\Parameter(
     *         description="Password",
     *         name="password",
     *         required=true,
     *         in="formData",
     *         type="string",
     *         default="123456"
     *     ),
     *     @SWG\Parameter(
     *         description="Password Confirmation",
     *         name="password_confirmation",
     *         required=true,
     *         in="formData",
     *         type="string",
     *         default="123456"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="User has registered successfully!",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="User registration has failed, for more details take a look of response",
     *     )
     * )
     */
    public function create(CreateValidator $validator)
    {
        $user = $this->getUserService()->create($validator);

        return Fractal::item($user)
            ->transformWith(new UserTransformer)
            ->withResourceName('User');
    }

    /**
     * @SWG\Get(
     *     path="/users/{id}",
     *     description="Get specific user",
     *     tags={"User"},
     *     @SWG\Parameter(
     *         description="ID (Uuid)",
     *         name="id",
     *         required=true,
     *         in="path",
     *         type="string",
     *         default="08e12d56-6913-44fd-bbd9-5f14306af501"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="User has been found successfully!",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="User not found!",
     *     )
     * )
     */
    public function get(string $id)
    {
        $user = $this->getUserService()->get($id);

        return Fractal::item($user)
            ->transformWith(new UserTransformer)
            ->withResourceName('User');
    }

    /**
     * @SWG\Get(
     *     path="/users",
     *     description="Find all users",
     *     tags={"User"},
     *     @SWG\Response(
     *         response=200,
     *         description="User has been found successfully!",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="User not found!",
     *     )
     * )
     */
    public function find()
    {
        $users = $this->getUserService()->find();

        if (!$users) {
            return $this->respondError("Users with given filter not found.");
        }

        return Fractal::collection($users)
            ->transformWith(new UserTransformer)
            ->withResourceName('User');
    }

    /**
     * @SWG\Patch(
     *     path="/users/{id}",
     *     description="Update specific user",
     *     tags={"User"},
     *     @SWG\Parameter(
     *         description="ID (Uuid)",
     *         name="id",
     *         required=true,
     *         in="path",
     *         type="string",
     *         default="08e12d56-6913-44fd-bbd9-5f14306af501"
     *     ),
     *     @SWG\Parameter(
     *         description="User's Fullname",
     *         name="name",
     *         required=false,
     *         in="formData",
     *         type="string",
     *         default=""
     *     ),
     *     @SWG\Parameter(
     *         description="Username",
     *         name="username",
     *         required=false,
     *         in="formData",
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         description="Status",
     *         name="status",
     *         required=false,
     *         in="formData",
     *         type="string",
     *         enum={"active","passive","pending"},
     *         default="active"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="User has been updated successfully!",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="User not found!",
     *     )
     * )
     */
    public function update(string $id, UpdateValidator $validator)
    {
        $user = $this->getUserService()->update($id, $validator);

        return Fractal::item($user)
            ->transformWith(new UserTransformer)
            ->withResourceName('User');
    }

    /**
     * @SWG\Delete(
     *     path="/users/{id}",
     *     description="Delete specific user",
     *     tags={"User"},
     *     @SWG\Parameter(
     *         description="ID (Uuid)",
     *         name="id",
     *         required=true,
     *         in="path",
     *         type="string",
     *         default=""
     *     ),
     *     @SWG\Response(
     *         response=204,
     *         description="User has been deleted successfully, No Content!",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Some problem, more details see in message",
     *     )
     * )
     */
    public function delete(string $id)
    {
        $user = $this->getUserService()->delete($id);

        return $this->respondNoContent();
    }

    /**
     * @SWG\Get(
     *     path="/users/me",
     *     description="Get authorized user",
     *     tags={"User"},
     *     @SWG\Response(
     *         response=200,
     *         description="Successful answer",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Some problem, more details see in message",
     *     )
     * )
     */
    public function me()
    {
        $user = $this->getUserService()->authorizedUser();

        return Fractal::item($user)
            ->transformWith(new UserTransformer)
            ->withResourceName('User');
    }

    /**
     * @SWG\Get(
     *     path="/users/{id}/roles",
     *     description="Get all roles for the user",
     *     tags={"User"},
     *     @SWG\Parameter(
     *         description="User ID",
     *         name="id",
     *         required=true,
     *         in="path",
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="User data with roles has been returned successfully!",
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="No permission to get user roles!",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="User not found!",
     *     )
     * )
     */
    public function findRoles(string $id)
    {
        $user = $this->getUserService()->findRoles($id);

        return Fractal::item($user)
            ->transformWith(new UserTransformer)
            ->withResourceName('User')
            ->parseIncludes('roles');
    }

    /**
     * @SWG\Post(
     *     path="/users/{userId}/roles/{roleId}",
     *     description="Attach role to the user",
     *     tags={"User"},
     *     @SWG\Parameter(
     *         description="User ID",
     *         name="userId",
     *         required=true,
     *         in="path",
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         description="Role ID",
     *         name="roleId",
     *         required=true,
     *         in="path",
     *         type="integer",
     *         default="1"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Role has been added to the user successfully!",
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="No permission to attach role to user!",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Role or User not found!",
     *     ),
     * )
     */
    public function attachRole(string $userId, int $roleId)
    {
        $user = $this->getUserService()->attachRole($userId, $roleId);

        return Fractal::item($user)
            ->transformWith(new UserTransformer)
            ->withResourceName('User')
            ->parseIncludes('roles');
    }

    /**
     * @SWG\Delete(
     *     path="/users/{userId}/roles/{roleId}",
     *     description="Attach role to the user",
     *     tags={"User"},
     *     @SWG\Parameter(
     *         description="User ID",
     *         name="userId",
     *         required=true,
     *         in="path",
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         description="Role ID",
     *         name="roleId",
     *         required=true,
     *         in="path",
     *         type="integer",
     *         default="1"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Role has been added to the user successfully!",
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="No permission to detach role from user!",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Role or User not found!",
     *     ),
     * )
     */
    public function detachRole(string $userId, int $roleId)
    {
        $user = $this->getUserService()->detachRole($userId, $roleId);

        return Fractal::item($user)
            ->transformWith(new UserTransformer)
            ->withResourceName('User')
            ->parseIncludes('roles');
    }
}
