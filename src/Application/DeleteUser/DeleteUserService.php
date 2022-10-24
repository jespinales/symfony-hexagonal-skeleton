<?php

namespace App\Application\DeleteUser;

use App\Domain\User\IUserRepository;
use App\Domain\User\UserId;

class DeleteUserService
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(DeleteUserRequest $request): void
    {
        $id = new UserId($request->id());

        $user = $this->userRepository->findById($id);

        if(!$user){
            throw new UserDoesNotExistException();
        }

        $this->userRepository->deleteById($id);
    }
}