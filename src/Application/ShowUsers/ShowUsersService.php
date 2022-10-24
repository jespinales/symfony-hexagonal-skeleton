<?php

namespace App\Application\ShowUsers;

use App\Domain\User\IUserRepository;

class ShowUsersService
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(ShowUsersRequest $request): ShowUsersResponse
    {
        $usersPaginated = $this->userRepository
            ->getPaginated($request->page(), $request->perPage());

        return new ShowUsersResponse($usersPaginated);
    }

}