<?php

namespace App\Application\DeleteUser;

use App\Domain\User\IUserRepository;
use App\Domain\User\UserId;

class DeleteUserService
{
    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(DeleteUserRequest $request)
    {
        $id = new UserId($request->id());

        $this->userRepository->deleteById($id);
    }
}