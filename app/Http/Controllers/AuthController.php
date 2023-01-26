<?php

namespace App\Http\Controllers;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LogoutAction;
use App\Actions\Auth\RegisterAction;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * User Registration
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $action = new RegisterAction($request);
        $action->run();

        return response()->json([
            'token' => $action->getToken(),
            'token_type' => 'Bearer'
        ]);
    }

    /**
     * User login
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $action = new LoginAction($request);
        $action->run();

        return response()->json([
            'token' => $action->getToken(),
            'token_type' => 'Bearer'
        ]);
    }

    /**
     * User logout
     *
     * @param LoginRequest $request
     */
    public function logout(Request $request)
    {
        $action = new LogoutAction($request);
        return $action->run();
    }
}
