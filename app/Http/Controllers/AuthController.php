<?php


namespace App\Http\Controllers;


use App\Exceptions\IllegalArgumentException;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\RepositoryContracts\UserRepository;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * AuthController constructor.
     * @param  UserRepository  $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(CreateUserRequest $request)
    {
        $existingUser = $this->userRepository->findByEmail($request->email);
        if ($existingUser) {
            throw new IllegalArgumentException('User with email already exist');
        }
        $user = $this->userRepository->createUser($request->all());
        return $this->successfulResponse(201, $user, 'User Successfully created');
    }

    public function login(LoginRequest $loginRequest)
    {
        $user = $this->userRepository->findByEmail(strtolower($loginRequest->email));
        if (!$user) {
            throw new IllegalArgumentException('User already exist');
        }
        if (!Hash::check($loginRequest->password, $user->password)) {
            throw new IllegalArgumentException('Invalid email or password');
        }
        return $this->successfulResponse(200, [
            'token' => $user->createToken('default')->plainTextToken
        ]);
    }
}
