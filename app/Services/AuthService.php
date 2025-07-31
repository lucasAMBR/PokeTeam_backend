<?php
    namespace App\Services;

    use App\Repositories\UserRepository;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Validation\ValidationException;

    class AuthService
    {
        protected UserRepository $userRepository;

        public function __construct(UserRepository $userRepository)
        {
            $this->userRepository = $userRepository;
        }

        public function login(string $email, string $password): array
        {
            $user = $this->userRepository->findByEmail($email);

            if(!$user ||  !Hash::check($password, $user->password)){
                throw ValidationException::withMessages([
                    'email' => ['Invalid credentials.'],
                ]);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return [
                'acess_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ];
        }
    }