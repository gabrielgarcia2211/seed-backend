<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\RegisterUserRequest;
use App\Http\Controllers\ResponseController as Response;

class UserController extends Controller
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterUserRequest $request)
    {
        try {
            $user = $this->userService->createUser($request->all());
            return Response::sendResponse($user, 'Registro creado con éxito.');
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Response::sendError('Ocurrio un error inesperado al intentar procesar la solicitud', 500);
        }
    }

    public function login(LoginUserRequest $request)
    {
        try {
            $response = $this->userService->login($request->all());
            if(isset($response['success']) && !$response['success']){
                return Response::sendError($response['message'], 400);
            }
            return Response::sendResponse($response, 'Logeado con éxito.');
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Response::sendError('Ocurrio un error inesperado al intentar procesar la solicitud', 500);
        }
    }

    public function logout()
    {
        try {
            $this->userService->logout();
            return Response::sendResponse([], 'Sesión cerrada con éxito.');
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Response::sendError('Ocurrio un error inesperado al intentar procesar la solicitud', 500);
        }

    }
}
