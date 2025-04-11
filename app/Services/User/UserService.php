<?php

namespace App\Services\User;

use Illuminate\Support\Facades\Hash;
use App\Interfaces\User\UserRepositoryInterface;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(array $userData)
    {
        $user = $this->userRepository->create($userData);
        $token = $user->createToken('web-app-token')->plainTextToken;
        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function login(array $data)
    {
        $email = $data['email'] ?? null;
        $user = $this->userRepository->findByEmail($email);
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return [
                'success' => false,
                'message' => 'Estas credenciales no coinciden con nuestros registros.'
            ];
        }
        $token = $user->createToken('web-app-token')->plainTextToken;
        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return true;
    }
}
