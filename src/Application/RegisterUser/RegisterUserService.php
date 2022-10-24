<?php

namespace App\Application\RegisterUser;

use App\Domain\User\IUserRepository;
use App\Domain\User\User;
use App\Domain\User\UserEmail;
use App\Domain\User\UserName;

class RegisterUserService
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(RegisterUserRequest $request): RegisterUserResponse
    {
        $email = new UserEmail( $request->email() );
        $name = new UserName( $request->name() );

        $user = $this->userRepository
            ->findByEmail($email);

        if($user){
            throw new UserAlreadyExistsException();
        }

        $user = new User(
            $this->userRepository->nextIdentity(),
            $name,
            $email
        );

        $this->userRepository
            ->save($user);

        return new RegisterUserResponse($user);
    }
}