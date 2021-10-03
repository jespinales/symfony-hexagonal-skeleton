<?php

namespace App\Application\ShowUsers;

use App\Domain\User\User;

class ShowUsersResponse
{
    private array $users = [];

    /**
     * @param User[] $users
     */
    public function __construct(array $users)
    {
        foreach ($users as $user){
            $this->users[] = [
                'id' => $user->getId()->id(),
                'name' => $user->getName()->name(),
                'email' => $user->getEmail()->email(),
            ];
        }
    }

    public function users(): array
    {
        return $this->users;
    }
}