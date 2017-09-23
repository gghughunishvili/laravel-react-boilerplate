<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Users\AddRole;
use App\Http\Requests\Users\Create;
use App\Http\Requests\Users\Delete;
use App\Http\Requests\Users\Find;
use App\Http\Requests\Users\Get;
use App\Http\Requests\Users\RemoveRole;
use App\Http\Requests\Users\Update;
use App\Services\UserService;
use App\Transformers\UserTransformer;
use Fractal;

class UserController extends ApiController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

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
    public function create(Create $request)
    {
        $user = $this->userService->create($request->request);

        return Fractal::item($user)
            ->transformWith(new UserTransformer)
            ->withResourceName('user');
    }

    /**
     * @SWG\Get(
     *     path="/users/{id}",
     *     description="Get specific user when you have permission!",
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
    public function get($id, Get $request)
    {
        $user = $this->userService->get($id);

        return Fractal::item($user)
            ->transformWith(new UserTransformer)
            ->withResourceName('user');
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
    public function find(Find $request)
    {
        $users = $this->userService->find();

        if (!$users) {
            return $this->respondError("Users with given filter not found.");
        }

        return Fractal::collection($users)
            ->transformWith(new UserTransformer)
            ->withResourceName('user');
    }

    /**
     * @SWG\Patch(
     *     path="/users/{id}",
     *     description="Update specific user when you have permission!",
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
    public function update($id, Update $request)
    {
        $user = $this->userService->update($id, $request->request);

        return Fractal::item($user)
            ->transformWith(new UserTransformer)
            ->withResourceName('user');
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
    public function delete($id, Delete $request)
    {
        $user = $this->userService->delete($id);

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
        $user = $this->userService->authorizedUser();

        return Fractal::item($user)
            ->transformWith(new UserTransformer)
            ->withResourceName('user');
    }

    /**
     * @SWG\Post(
     *     path="/users/{user_id}/roles/{role_id}",
     *     description="Attach role to the user",
     *     tags={"User"},
     *     @SWG\Parameter(
     *         description="User ID",
     *         name="user_id",
     *         required=true,
     *         in="path",
     *         type="string",
     *         default="",
     *     ),
     *     @SWG\Parameter(
     *         description="Role ID",
     *         name="role_id",
     *         required=true,
     *         in="path",
     *         type="string",
     *         default="",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Role has been attached succesfully!",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="The role is already attached to the user",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="A user or a role with given id wasn't found!",
     *     ),
     * )
     */
    public function addRole($user_id, $role_id, AddRole $request)
    {
        $data = $this->userService->attachRole($user_id, $role_id);

        return Fractal::item($data)
            ->transformWith(new UserTransformer)
            ->withResourceName('user')
            ->parseIncludes('roles');
    }

    /**
     * @SWG\Delete(
     *     path="/users/{user_id}/roles/{role_id}",
     *     description="Remove role from the user",
     *     tags={"User"},
     *     @SWG\Parameter(
     *         description="User ID",
     *         name="user_id",
     *         required=true,
     *         in="path",
     *         type="string",
     *         default="",
     *     ),
     *     @SWG\Parameter(
     *         description="Role ID",
     *         name="role_id",
     *         required=true,
     *         in="path",
     *         type="string",
     *         default="",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Role has been removed succesfully!",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="The role isn't attached to the user",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="A user or a role with given id wasn't found!",
     *     ),
     * )
     */
    public function removeRole($user_id, $role_id, RemoveRole $request)
    {
        $data = $this->userService->detachRole($user_id, $role_id);

        return Fractal::item($data)
            ->transformWith(new UserTransformer)
            ->withResourceName('user')
            ->parseIncludes('roles');
    }


}
