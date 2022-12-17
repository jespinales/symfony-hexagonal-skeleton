<?php

namespace App\Application\RegisterUser;

use App\Domain\User\IPasswordHashing;
use App\Domain\User\IUserRepository;
use App\Domain\User\User;
use App\Domain\User\UserEmail;
use App\Domain\User\UserName;
use App\Domain\User\UserPassword;

class RegisterUserService
{
    private IUserRepository $userRepository;
    private IPasswordHashing $passwordHashing;

    public function __construct(
        IUserRepository $userRepository,
        IPasswordHashing $passwordHashing
    ) {
        $this->userRepository = $userRepository;
        $this->passwordHashing = $passwordHashing;
    }

    public function execute(RegisterUserRequest $request): RegisterUserResponse
    {
        $email = new UserEmail( $request->email() );
        $name = new UserName( $request->name() );
        $password = UserPassword::fromPlaneText(
            $request->password(),
            $this->passwordHashing
        );

        $user = $this->userRepository
            ->findByEmail($email);

        if($user){
            throw new UserAlreadyExistsException();
        }

        $user = new User(
            $this->userRepository->nextIdentity(),
            $name,
            $email,
            $password
        );

        $this->userRepository
            ->save($user);

        return new RegisterUserResponse($user);
    }
}