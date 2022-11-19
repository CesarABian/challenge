<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AbstractController;
use App\Http\Requests\Api\LoginUserRequest;
use App\Http\Requests\Api\StoreUserRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends AbstractController
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
            return $this->simpleJsonResponse($th->getMessage(), false, 500);
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
            return $this->simpleJsonResponse($th->getMessage(), false, 500);
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
            return $this->simpleJsonResponse($th->getMessage(), false, 500);
        }
    }
}