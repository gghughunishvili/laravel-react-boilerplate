<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\MyResponseTrait;
use Psr\Http\Message\ServerRequestInterface;
use Request;
use \Laravel\Passport\Http\Controllers\AccessTokenController as AccessTokenParentController;

class AccessTokenController extends AccessTokenParentController
{

    use MyResponseTrait;

    /**
     * @SWG\Post(
     *     path="/oauth/token",
     *     description="Authorize a client to access the user's account.",
     *     tags={"Auth"},
     *     @SWG\Parameter(
     *         description="Grant Type",
     *         enum={"password","client_credentials"},
     *         name="grant_type",
     *         required=true,
     *         in="formData",
     *         type="string",
     *         default="password"
     *     ),
     *     @SWG\Parameter(
     *         description="Client ID",
     *         name="client_id",
     *         required=true,
     *         in="formData",
     *         type="integer",
     *         default="1"
     *     ),
     *     @SWG\Parameter(
     *         description="Client Secret",
     *         name="client_secret",
     *         required=true,
     *         in="formData",
     *         type="string",
     *         default="Zzxh8l1c55OLQ5w2RVN0rcTZSqzKaSfDkc0h0nlg"
     *     ),
     *     @SWG\Parameter(
     *         description="Username or Email",
     *         name="username",
     *         required=false,
     *         in="formData",
     *         type="string",
     *         default="test"
     *     ),
     *     @SWG\Parameter(
     *         description="Password",
     *         name="password",
     *         required=false,
     *         in="formData",
     *         type="string",
     *         default="123456"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Returns generated token",
     *     ),
     * )
     */
    public function issueToken(ServerRequestInterface $request)
    {
        $parent_issue_token = parent::issueToken($request);
        return $parent_issue_token;
    }

    /**
     * @SWG\Patch(
     *     path="/oauth/token",
     *     description="Log the user out of the application.",
     *     tags={"Auth"},
     *     @SWG\Response(
     *         response=204,
     *         description="User has been logged out successfully!",
     *     )
     * )
     */
    public function revokeToken(Request $request)
    {
        if (!is_null(auth()->user()->token())) {
            $user = auth()->user();
            $user->token()->revoke();
        }
        return $this->respondNoContent();
    }
}
