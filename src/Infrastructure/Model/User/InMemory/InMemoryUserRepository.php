<?php

namespace App\Infrastructure\Model\User\InMemory;

use App\Domain\User\IUserRepository;
use App\Domain\User\User;
use App\Domain\User\UserEmail;
use App\Domain\User\UserId;
use Ramsey\Uuid\Uuid;

class InMemoryUserRepository implements IUserRepository
{
    private array $users = [];

    public function nextIdentity(): UserId
    {
        return new UserId(Uuid::uuid1());
    }

    public function save(User $user): void
    {
        $this->users[$user->getId()->id()] = $user;
    }

    public function findByEmail(UserEmail $email): ?User
    {
        $response = null;

        foreach ($this->users as $user){
            if($email->equals( $email )){
                $response = $user;
                break;
            }
        }

        return $response;
    }

    public function deleteById(UserId $id): void
    {
        unset($this->users[$id->id()]);
    }

    public function getAll(): array
    {
        return $this->users;
    }
}