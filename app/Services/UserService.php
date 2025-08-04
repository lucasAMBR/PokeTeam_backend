<?php
    namespace App\Services;

    use App\Repositories\UserRepository;
    use Illuminate\Support\Facades\Hash;

    class UserService
    {
        public function __construct(protected UserRepository $repository){}

        public function register(array $data)
        {
            $existingUser = $this->repository->findByEmail($data['email']);

            if ($existingUser) {
                abort(409, "Email já está em uso!");
            }

            $data['password'] = Hash::make($data['password']);
            return $this->repository->register($data);
        }
    }
