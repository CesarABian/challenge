<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Http\Requests\Api\StoreUserRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    /**
     * @var UserService $service
     */
    protected UserService $service;

    /**
     * __construct
     *
     * @param  UserRepositoryInterface $repository
     * @return void
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->service = new UserService($repository);
    }
    
    /**
     * to return on error case
     *
     * @param  \Throwable $th
     * @return JsonResponse
     */
    protected function onError(\Throwable $th): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $th->getMessage(),
        ], 500);
    }

    /**
     * creates a user
     * 
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function createUser(StoreUserRequest $request): JsonResponse
    {
        try {
            $user = $this->service->store($request->validated());
            return (new JsonResponse([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
            ]))->setStatusCode(201);
        } catch (\Throwable $th) {
            return $this->onError($th);
        }
    }

    /**
     * login the user
     * 
     * @param LoginUserRequest $request
     * @return JsonResponse
     */
    public function loginUser(LoginUserRequest $request): JsonResponse
    {
        try {
            if(!Auth::attempt($request->validated())){
                (new JsonResponse([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ]))->setStatusCode(401);
            }
            $user = $this->service->findBy('email', $request->email);
            return (new JsonResponse([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
            ]))->setStatusCode(200);

        } catch (\Throwable $th) {
            return $this->onError($th);
        }
    }
    
    /**
     * logout the user
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function logoutUser(Request $request): JsonResponse
    {
        try {
            $accessToken = $request->bearerToken();
            $token = PersonalAccessToken::findToken($accessToken);
            $token->delete();
            return (new JsonResponse([
                'status' => true,
                'message' => 'User Logged Out Successfully',
            ]))->setStatusCode(200);
        } catch (\Throwable $th) {
            return $this->onError($th);
        }
    }
}