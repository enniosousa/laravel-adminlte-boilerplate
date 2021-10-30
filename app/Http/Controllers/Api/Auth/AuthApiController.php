<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\LoginApiRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use InfyOm\Generator\Utils\ResponseUtil;

/**
 * Class AuthApiController
 * @package App\Http\Controllers\Api
 */

class AuthApiController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepositorysitory;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param LoginApiRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/auth/login",
     *      summary="Create a API token to user",
     *      tags={"Auth"},
     *      description="Create a API token to user",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Users details",
     *          required=true,
     *          @SWG\Schema(
     *              @SWG\Property(
     *                  property="email",
     *                  description="User email address",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="password",
     *                  description="User password",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="device_name",
     *                  description="Device name",
     *                  type="string"
     *              ),
     *          )
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="object",
     *                  @SWG\Property(
     *                      property="token",
     *                      description="Login user token",
     *                      type="string"
     *                  ),
     *                  @SWG\Property(
     *                      property="user",
     *                      type="object",
     *                      description="User data",
     *                      ref="#/definitions/User"
     *                  ),
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function login(LoginApiRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);
        }

        return $this->sendResponse(
            $result = [
                'token' => $user->createToken($request->device_name)->plainTextToken,
                'user'=> $user,
            ],
            $message = 'Token created'
        );
    }

    /**
     * @param UserRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/auth/register",
     *      summary="Store a newly created User in storage",
     *      tags={"Auth"},
     *      description="Store User",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="User that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/User")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/User"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function register(UserRequest $request)
    {
        $input = $request->all();

        $user = $this->userRepository->create($input);
        return Response::json(ResponseUtil::makeResponse(
            $message = trans('messages.saved', ['model' => trans('models/users.singular')]), 
            $result = $user->toArray()
        ));
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/auth/logout",
     *      summary="Unauthenticate user",
     *      tags={"Auth"},
     *      description="Revoke the API token that was used to authenticate the current request",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function logout(Request $request)
    {
        // Revoke the token that was used to authenticate the current request...
        $request->user()->currentAccessToken()->delete();

        return Response::json([
            'success' => true,
            'message' => $message = 'Token successsfully deleted.'
        ], 200);
    }


    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/auth/me",
     *      summary="User profile",
     *      tags={"Auth"},
     *      description="Get user data and information about the authenticate user",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/User"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function me(Request $request)
    {
        return Response::json(ResponseUtil::makeResponse(
            $message = trans('messages.retrieved', ['model' => trans('models/users.plural')]),
            $result = $request->user()
        ));
    }
}
