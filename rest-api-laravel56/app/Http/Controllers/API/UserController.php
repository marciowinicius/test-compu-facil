<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Services\UserServices;

class UserController extends BaseController
{
    /**
     * @var
     */
    protected $userService;

    public function __construct(UserServices $userServices)
    {
        $this->userService = $userServices;
    }


    /**
     * @SWG\Post(
     *     path="/register",
     *     summary="Register a user",
     *     tags={"User"},
     *     @SWG\Parameter(
     *         name="name",
     *         description="Name",
     *         in="formData",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="email",
     *         description="Email",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="email"
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         description="Password",
     *         in="formData",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="c_password",
     *         description="Confirm Password",
     *         in="formData",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Response(response="200", description="Return user data with access_token",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="status", type="string", example="success"),
     *             @SWG\Property(
     *                 property="data",
     *                 type="object",
     *                 @SWG\Property(property="name", type="string", example="Joao"),
     *                 @SWG\Property(property="token", type="string", example="12k091k2091283102k3.12093901283"),
     *             ),
     *             @SWG\Property(property="message", type="string", example=""),
     *          ),
     *     ),
     * )
     */
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $input = $request->all();

        $validator = $this->userService->validation($input);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken($user->email)->accessToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * @SWG\Post(
     *     path="/login",
     *     summary="Login",
     *     tags={"User"},
     *     @SWG\Parameter(
     *         name="username",
     *         in="formData",
     *         description="The username is the email",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         in="formData",
     *         description="Password",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Response(response="200", description="Return user data with access_token",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="status", type="string", example="success"),
     *             @SWG\Property(
     *                 property="data",
     *                 type="object",
     *                 @SWG\Property(property="name", type="string", example="Joao"),
     *                 @SWG\Property(property="token", type="string", example="12k091k2091283102k3.12093901283"),
     *             ),
     *             @SWG\Property(property="message", type="string", example=""),
     *          ),
     *     ),
     * )
     */
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $email = $request->get('username');
        $password = $request->get('password');

        $user = User::whereEmail($email)->first();

        if (!is_null($user)) {
            if (Hash::check($password, $user->password)) {
                $token = $user->createToken($user->email)->accessToken;
                return response()->json([
                    'status' => 'success',
                    'data' => ['token' => $token, 'name' => $user->name],
                    'msg' => 'ok'
                ]);
            }
        }

        return $this->sendError('Username or password invalid.');
    }
}