<?php

namespace App\Services;

use App\Entities\User;
use App\Repositories\UserRepository;
use Psr\Log\LoggerInterface;

class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private LoggerInterface $logger
    ) {}

    public function createUser(array $data): User
    {
        dump('Creating user:', $data);
        $user = new User();
        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setPassword(bcrypt($data['password']));
        $isAdmin = isset($data['isAdmin']) ?
           filter_var($data['isAdmin'], FILTER_VALIDATE_BOOLEAN) : false;
        $user->setIsAdmin($isAdmin);

        $this->userRepository->save($user);

        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }

    public function updateProfile(User $user, array $data): void
    {
        $user->setName($data['name']);
        if (isset($data['password'])) {
            $user->setPassword(bcrypt($data['password']));
        }

        $this->userRepository->save($user);
    }

    public function getTotalUsers(): int
    {
        return $this->userRepository->getTotalCount();
    }

    public function getAllUsers()
    {
        return $this->userRepository->findAll();
    }
}
