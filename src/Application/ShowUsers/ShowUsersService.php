<?php

namespace App\Application\ShowUsers;

use App\Application\Shared\Model\User\IUserCollectionDataTransformer;
use App\Domain\User\IUserRepository;

class ShowUsersService
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(): ShowUsersResponse
    {
        $users = $this->userRepository->getAll();

        return new ShowUsersResponse($users);
    }

}