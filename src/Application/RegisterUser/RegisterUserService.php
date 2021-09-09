<?php

namespace App\Application\RegisterUser;

use App\Application\Shared\Model\User\IUserDataTransformer;
use App\Domain\User\IUserRepository;
use App\Domain\User\User;
use App\Domain\User\UserAlreadyExistsException;
use App\Domain\User\UserEmail;
use App\Domain\User\UserName;

class RegisterUserService
{
    private IUserRepository $userRepository;
    private IUserDataTransformer $userDataTransformer;

    public function __construct(
        IUserRepository $userRepository,
        IUserDataTransformer $userDataTransformer
    ){
        $this->userRepository = $userRepository;
        $this->userDataTransformer = $userDataTransformer;
    }

    public function execute(RegisterUserRequest $request)
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

        $this->userDataTransformer
            ->write($user);
    }

    public function userDataTransformer(): IUserDataTransformer
    {
        return $this->userDataTransformer;
    }
}