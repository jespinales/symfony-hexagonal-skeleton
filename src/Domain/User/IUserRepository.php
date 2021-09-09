<?php

namespace App\Domain\User;

interface IUserRepository
{
    public function nextIdentity(): UserId;

    public function save(User $user): void;

    public function findByEmail(UserEmail $email): ?User;

    public function deleteById(UserId $id): void;

    /**
     * @return User[]
     */
    public function getAll(): array;
}