<?php

namespace App\Infrastructure\Model\User\InMemory;

use App\Domain\User\IUserRepository;
use App\Domain\User\User;
use App\Domain\User\UserEmail;
use App\Domain\User\UserId;
use App\Infrastructure\Model\Paginate;
use Ramsey\Uuid\Uuid;

class InMemoryUserRepository implements IUserRepository
{
    private array $users = [];

    public function nextIdentity(): UserId
    {
        return new UserId(Uuid::uuid1());
    }

    public function findByEmail(UserEmail $email): ?User
    {
        $response = null;

        /** @var User $user */
        foreach ($this->users as $user){
            if($email->equals( $user->getEmail() )){
                $response = $user;
                break;
            }
        }

        return $response;
    }

    public function findById(UserId $id): ?User
    {
        $response = null;

        /** @var User $user */
        foreach ($this->users as $user){
            if( $id->equals( $user->getId()) ){
                $response = $user;
                break;
            }
        }

        return $response;
    }

    public function getAll(): array
    {
        return $this->users;
    }

    public function getPaginated($page = 1, $perPage = 15): Paginate
    {
        $response = array_slice($this->users, $page*$perPage-$perPage, $page*$perPage);

        $totalItems = count($this->users);
        return new Paginate($page, $perPage, $totalItems, $response);
    }

    public function save(User $user): void
    {
        $this->users[$user->getId()->id()] = $user;
    }

    public function deleteById(UserId $id): void
    {
        unset($this->users[$id->id()]);
    }
}