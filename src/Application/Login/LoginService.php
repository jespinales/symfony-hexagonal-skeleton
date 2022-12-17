<?php

namespace App\Application\Login;

use App\Domain\User\IPasswordHashing;
use App\Domain\User\IUserRepository;
use App\Domain\User\User;
use App\Domain\User\UserEmail;
use App\Domain\User\UserPassword;

class LoginService
{
    private IUserRepository $userRepository;
    private IPasswordHashing $passwordHashing;

    public function __construct(
        IUserRepository $userRepository,
        IPasswordHashing $passwordHashing)
    {
        $this->userRepository = $userRepository;
        $this->passwordHashing = $passwordHashing;
    }

    public function execute(LoginRequest $request)
    {
        $password = $request->password();
        $email = new UserEmail($request->email());

        $user = $this->userRepository
            ->findByEmail($email);

        if(!$user){
            throw new UserDoesntExistException();
        }

        if (!$this->isValidPassword($user, $password)) {
            throw new UserPasswordInvalidException();
        }

        return new LoginResponse($user);
    }

    private function isValidPassword(User $user, string $password)
    {
        return $this->passwordHashing
            ->verify($password, $user->getPasswordHash());
    }
}