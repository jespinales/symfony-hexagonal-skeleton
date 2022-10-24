<?php

namespace App\Application\ShowUsers;


use App\Infrastructure\Model\Paginate;

class ShowUsersResponse
{
    private array $response;

    private array $users = [];

    public function __construct(Paginate $usersPaginated)
    {
        foreach ($usersPaginated->getData() as $user){
            $this->users[] = [
                'id' => $user->getId()->id(),
                'name' => $user->getName()->name(),
                'email' => $user->getEmail()->email(),
            ];
        }

        $this->response = [
            'total' => $usersPaginated->getTotal(),
            'per_page' => $usersPaginated->getPerPage(),
            'current_page' => $usersPaginated->getCurrentPage(),
            'last_page' => $usersPaginated->getLastPage(),
            'from' => $usersPaginated->getFrom(),
            'to' => $usersPaginated->getTo(),
            'users' => $this->users
        ];
    }

    public function pagination(): array
    {
        return $this->response;
    }
}